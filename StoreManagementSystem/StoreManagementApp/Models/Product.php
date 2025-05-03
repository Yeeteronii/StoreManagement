<?php
include_once "Model.php";

class Product extends Model {
    public $productId;
    public $productName;
    public $categoryId;
    public $categoryName;
    public $cost;
    public $priceToSell;
    public $threshold;
    public $quantity;
    public $isActive;

    function __construct($param = null) {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT p.*, c.categoryName FROM products p JOIN categories c ON p.categoryId = c.categoryId WHERE p.productId = ? AND p.isActive = 1");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row) {
        $this->productId = $row->productId;
        $this->productName = $row->productName;
        $this->cost = $row->cost;
        $this->priceToSell = $row->priceToSell;
        $this->categoryId = $row->categoryId;
        $this->categoryName = $row->categoryName;
        $this->threshold = $row->threshold;
        $this->quantity = $row->quantity;
        $this->isActive = $row->isActive;
    }

    public static function list() {
        $list = [];
        $sql = "SELECT p.productId, p.productName, p.cost, p.priceToSell, p.categoryId, p.threshold, p.quantity, p.isActive, c.categoryName
                FROM products p
                JOIN categories c ON c.categoryId = p.categoryId
                WHERE p.isActive = 1";
        $conn = Model::connect();
        $result = $conn->query($sql);
        while ($row = $result->fetch_object()) {
            $list[] = new Product($row);
        }
        return $list;
    }

    public static function listFiltered($keyword) {
        $list = [];
        $conn = self::connect();
        $sql = "SELECT p.productId, p.productName, p.cost, p.priceToSell, p.categoryId, p.threshold, p.quantity, p.isActive, c.categoryName
            FROM products p
            JOIN categories c ON c.categoryId = p.categoryId
            WHERE p.productName LIKE ? AND p.isActive = 1";
        $stmt = $conn->prepare($sql);
        $likeKeyword = "%" . $keyword . "%";
        $stmt->bind_param("s", $likeKeyword);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_object()) {
            $list[] = new Product($row);
        }
        $stmt->close();
        return $list;
    }


    public static function add($data) {
        $conn = Model::connect();
        $sql = "INSERT INTO products (productName, cost, priceToSell, categoryId, threshold, quantity, isActive) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiii", $data['productName'], $data['cost'], $data['priceToSell'], $data['categoryId'], $data['threshold'], $data['quantity']);
        $stmt->execute();
        $stmt->close();
    }

    public function update($data) {
        $conn = Model::connect();
        $sql = "UPDATE products SET productName = ?, cost = ?, priceToSell = ?, categoryId = ?, threshold = ?, quantity = ? WHERE productId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiiii", $data['productName'], $data['cost'], $data['priceToSell'], $data['categoryId'], $data['threshold'], $data['quantity'], $this->productId);
        $stmt->execute();
        $stmt->close();
    }

    public function delete() {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE products SET isActive = 0 WHERE productId = ?");
        $stmt->bind_param("i", $this->productId);
        $stmt->execute();
    }

    public static function deleteMultiple($ids) {
        $conn = self::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("UPDATE products SET isActive = 0 WHERE productId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
    }
}
