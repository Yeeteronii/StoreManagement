<?php

include_once "Models/Model.php";

class User extends Model {
    public $id;
    public $username;
    public $password;

    public static function connect() {
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "store_management";

        $conn = new mysqli($server, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Connection error!<br>" . $conn->connect_error);
        }
        return $conn;
    }

    public function __construct($param = null) {
        if (is_object($param) || is_array($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = self::connect();
            $sql = "SELECT * FROM `users` WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            $this->setProperties($row);
        }
    }

    public static function authenticate($username, $password) {
        $conn = self::connect();
        $sql = "SELECT * FROM `users` WHERE `username` = ? AND `password` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object();
    }

    public static function getTwoFASecret($userId) {
        $conn = self::connect();
        $sql = "SELECT twofa_secret FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        return $row ? $row->twofa_secret : null;
    }

    public static function setTwoFASecret($userId, $secret) {
        $conn = self::connect();
        $sql = "UPDATE users SET twofa_secret = ?, twofa_enabled = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $secret, $userId);
        return $stmt->execute();
    }
    public static function clearTwoFASecret($userId) {
        $conn = self::connect();
        $sql = "UPDATE users SET twofa_secret = NULL, twofa_enabled = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public static function getRole($userId) {
        $conn = self::connect();
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
    public static function getUsername($userId) {
        $conn = self::connect();
        $sql = "SELECT username FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_object();
        return $row ? $row->username : null;
    }
    

    private function setProperties($obj) {
        if ($obj) {
            $this->id = isset($obj->id) ? $obj->id : null;
            $this->username = isset($obj->username) ? $obj->username : '';
            $this->password = isset($obj->password) ? $obj->password : '';
        }
    }
}
