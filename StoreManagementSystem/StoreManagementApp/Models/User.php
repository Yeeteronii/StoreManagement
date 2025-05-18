<?php

include_once "Models/Model.php";

class User extends Model
{
    public $id;
    public $username;
    public $password;
    public $role;
    public function __construct($param = null)
    {
        if (is_object($param) || is_array($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $sql = "
                SELECT u.*, g.name AS role FROM users u JOIN users_groups ug ON u.id = ug.user_id
                JOIN groups g ON ug.group_id = g.id WHERE u.id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            $this->setProperties($row);
        }
    }

    public static function authenticate($username, $password)
    {
        $conn = Model::connect();
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public static function getTwoFASecret($userId)
    {
        $conn = Model::connect();
        $sql = "SELECT twofa_secret FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        return $row ? $row->twofa_secret : null;
    }

    public static function setTwoFASecret($userId, $secret)
    {
        $conn = Model::connect();
        $sql = "UPDATE users SET twofa_secret = ?, twofa_enabled = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $secret, $userId);
        return $stmt->execute();
    }

    public static function clearTwoFASecret($userId)
    {
        $conn = Model::connect();
        $sql = "UPDATE users SET twofa_secret = NULL, twofa_enabled = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public static function getRole($userId)
    {
        $conn = Model::connect();
        $sql = "SELECT g.name 
            FROM users_groups ug
            JOIN groups g ON ug.group_id = g.id
            WHERE ug.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_object()) {
            return strtolower($row->name);
        }
        return 'employee';
    }

    public static function getUsername($userId)
    {
        $conn = Model::connect();
        $sql = "SELECT username FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        return $row ? $row->username : null;
    }

    private function setProperties($row)
    {
        $this->id = $row->id;
        $this->username = $row->username;
        $this->password = $row->password;
        $this->role = $row->role;
    }



    public static function checkRight($user_id,$controller, $action){
        $sql = "SELECT * FROM users
                INNER JOIN users_groups ON( users.id=users_groups.user_id)
                INNER JOIN groups ON (users_groups.group_id = groups.id)
                INNER JOIN groups_actions ON (groups.id=groups_actions.group_id)
                INNER JOIN actions ON( groups_actions.action_id=actions.id)

                WHERE
                users.id=?
                AND actions.controller=?  
                AND actions.action=?
                LIMIT 1";


        $connection = Model::connect();
        $stmt = $connection->prepare($sql);

        $stmt->bind_param("iss",$user_id, $controller, $action);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();

        if($row) return true;
        return false;
    }

    public static function list($keyword, $sort, $dir)
    {
        $allowedSorts = ['username','role'];
        if (!in_array($sort, $allowedSorts)) $sort = 'username';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();
        $sql = "
            SELECT u.*, g.name AS role FROM users u 
                JOIN users_groups ug ON u.id = ug.user_id 
                JOIN groups g ON ug.group_id = g.id";
        $params = [];
        $types = '';

        if (!empty($keyword)) {
            $sql .= " WHERE u.username LIKE ?";
            $params[] = '%' . $keyword . '%';
            $types .= 's';
        }

        $sql .= " ORDER BY $sort $dir";

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];
        while ($row = $result->fetch_object()) {
            $list[] = new User($row);
        }
        $stmt->close();
        return $list;
    }

    public static function add($data)
    {
        $conn = Model::connect();
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $data['username'], $hashedPassword);
        $stmt->execute();
        $userId = $conn->insert_id;
        $stmt->close();

        $sql2 = "INSERT INTO users_groups (user_id, group_id) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $userId, $data['group_id']);
        $stmt2->execute();
        $stmt2->close();
    }

    public function update($data)
    {
        $conn = Model::connect();

        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $data['username'], $hashedPassword, $this->id);
            $stmt->execute();
            $stmt->close();
        } elseif (!empty($data['username'])) {
            $sql = "UPDATE users SET username = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $data['username'], $this->id);
            $stmt->execute();
            $stmt->close();
        }

        if (!empty($data['role'])) {
            $groupStmt = $conn->prepare("SELECT id FROM groups WHERE name = ?");
            $groupStmt->bind_param("s", $data['role']);
            $groupStmt->execute();
            $groupResult = $groupStmt->get_result();
            if ($groupRow = $groupResult->fetch_object()) {
                $groupId = $groupRow->id;

                $updateGroupStmt = $conn->prepare("UPDATE users_groups SET group_id = ? WHERE user_id = ?");
                $updateGroupStmt->bind_param("ii", $groupId, $this->id);
                $updateGroupStmt->execute();
                $updateGroupStmt->close();
            }
            $groupStmt->close();
        }
    }
    public static function delete($ids)
    {
        if (empty($ids)) return;

        $conn = Model::connect();

        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));

        $stmt1 = $conn->prepare("DELETE FROM users_groups WHERE user_id IN ($in)");
        if (!$stmt1) {
            throw new Exception("Prepare failed for users_groups: " . $conn->error);
        }
        $stmt1->bind_param($types, ...$ids);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("DELETE FROM users WHERE id IN ($in)");
        if (!$stmt2) {
            throw new Exception("Prepare failed for users: " . $conn->error);
        }
        $stmt2->bind_param($types, ...$ids);
        $stmt2->execute();
        $stmt2->close();
    }
    public static function getAllGroups()
    {
        $conn = Model::connect();
        $result = $conn->query("SELECT * FROM groups");
        $list = [];
        while ($row = $result->fetch_object()) {
            $list[] = $row;
        }
        return $list;
    }

}
