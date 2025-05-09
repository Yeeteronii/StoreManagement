<?php
include_once "Model.php";

class Supplier extends Model
{
    public $supplierId;
    public $supplierName;
    public $email;
    public $phoneNum;
    public $isActive;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT * FROM suppliers WHERE supplierId = ? AND isActive = 1");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->supplierId = $row->supplierId;
        $this->supplierName = $row->supplierName;
        $this->email = $row->email;
        $this->phoneNum = $row->phoneNum;
        $this->isActive = $row->isActive;
    }

    public static function listFilteredSorted($keyword, $sort, $dir)
    {
        $allowedSorts = ['supplierName', 'email', 'phoneNum'];
        if (!in_array($sort, $allowedSorts)) $sort = 'supplierName';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();
        $sql = "SELECT * FROM suppliers WHERE isActive = 1";
        $params = [];
        $types = '';

        if (!empty($keyword)) {
            $sql .= " AND supplierName LIKE ?";
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
            $list[] = new Supplier($row);
        }
        $stmt->close();
        return $list;
    }
    public static function add($data)
    {
        $conn = Model::connect();
        $sql = "INSERT INTO suppliers (supplierName, email, phoneNum, isActive) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $cleanPhone = preg_replace("/[^0-9]/", "", $data['phoneNum']);
        $stmt->bind_param("sss",
            $data['supplierName'],
            $data['email'],
            $cleanPhone
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = Model::connect();
        $sql = "UPDATE suppliers SET supplierName = ?, email = ?, phoneNum = ? WHERE supplierId = ?";
        $stmt = $conn->prepare($sql);
        $cleanPhone = preg_replace("/[^0-9]/", "", $data['phoneNum']);
        $stmt->bind_param("sssi",
            $data['supplierName'],
            $data['email'],
            $cleanPhone,
            $this->supplierId);
        $stmt->execute();
        $stmt->close();
    }

    public static function delete($ids)
    {
        $conn = Model::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("UPDATE suppliers SET isActive = 0 WHERE supplierId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $stmt->close();
    }
    public static function viewDeleted()
    {
        $conn = Model::connect();
        $sql = "SELECT * FROM suppliers WHERE isActive = 0";
        $result = $conn->query($sql);
        $list = [];
        while ($row = $result->fetch_object()) {
            $supplier = new Supplier($row);
            $list[] = $supplier;
        }
        return $list;
    }

    public static function restore($id)
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE suppliers SET isActive = 1 WHERE supplierId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
