<?php
include_once "Model.php";

class Shift extends Model
{
    public $shiftId;
    public $userId;
    public $day;
    public $startTime;
    public $endTime;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT s.*, u.username FROM shifts s 
                                    JOIN users u ON s.userId = u.id 
                                    WHERE s.shiftId = ?");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->shiftId = $row->shiftId;
        $this->userId = $row->userId;
        $this->day = $row->day;
        $this->startTime = $row->startTime;
        $this->endTime = $row->endTime;
    }

    public static function list()
    {
        $list = [];
        $sql = "SELECT s.*
                    FROM shifts s
                    ";
        $conn = Model::connect();
        $result = $conn->query($sql);
        while ($row = $result->fetch_object()) {
            $list[] = new Shift($row);
        }
        return $list;
    }


    public static function add($data)
    {
        $conn = self::connect();
        $sql = "INSERT INTO products (productName, cost, priceToSell, categoryId, threshold, quantity, isActive) 
                VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiii", $data['productName'], $data['cost'], $data['priceToSell'],
            $data['categoryId'], $data['threshold'], $data['quantity']);
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = self::connect();
        $sql = "UPDATE products 
                SET productName = ?, cost = ?, priceToSell = ?, categoryId = ?, threshold = ?, quantity = ? 
                WHERE productId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiiii", $data['productName'], $data['cost'], $data['priceToSell'],
            $data['categoryId'], $data['threshold'], $data['quantity'], $this->productId);
        $stmt->execute();
        $stmt->close();
    }

    public function delete()
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE products SET isActive = 0 WHERE productId = ?");
        $stmt->bind_param("i", $this->productId);
        $stmt->execute();
        $stmt->close();
    }

    public static function deleteMultiple($ids)
    {
        $conn = Model::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("UPDATE products SET isActive = 0 WHERE productId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $stmt->close();
    }
    public static function addToOrder($productId)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("INSERT INTO orders (productId, orderDate) VALUES (?, CURDATE())");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    }

    public static function isInOrder($productId)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT 1 FROM orders WHERE productId = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $isInOrder = $result->num_rows > 0;
        $stmt->close();
        return $isInOrder;
    }
}
