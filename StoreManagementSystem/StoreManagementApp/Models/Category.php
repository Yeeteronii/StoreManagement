<?php
include_once "Models/Model.php";
class Category {

    public $categoryId;
    public $categoryName;
    public $categoryTax;
    public $isActive;
    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT * FROM categories WHERE categoryId = ? AND isActive = 1");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->categoryId = $row->categoryId;
        $this->categoryName = $row->categoryName;
        $this->categoryTax = $row->categoryTax;
        $this->isActive = $row->isActive;
    }

    public static function list()
    {
        $list = [];
        $sql = "SELECT * FROM categories WHERE isActive = 1";
        $conn = Model::connect();
        $result = $conn->query($sql);
        while ($row = $result->fetch_object()) {
            $list[] = new Category($row);
        }
        return $list;
    }

    public static function listFilteredSorted($sort, $dir)
    {
        $allowedSorts = ['categoryName', 'categoryTax'];
        if (!in_array($sort, $allowedSorts)) $sort = 'categoryName';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();

        $sql = "SELECT * FROM categories WHERE isActive = 1 ORDER BY $sort $dir";

        $params = [];
        $types = '';

        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];
        while ($row = $result->fetch_object()) {
            $list[] = new Category($row);
        }
        $stmt->close();
        return $list;
    }

    

    public static function add($data)
    {
        $conn = Model::connect();
        $sql = "INSERT INTO categories (categoryName, categoryTax, isActive) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sd", $data['categoryName'], $data['categoryTax']);
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = Model::connect();
        $sql = "UPDATE categories SET categoryName = ?, categoryTax = ? WHERE categoryId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $data['productName'], $data['categoryTax'], $this->categoryId);
        $stmt->execute();
        $stmt->close();
    }

    public function delete()
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE categories SET isActive = 0 WHERE categoryId = ?");
        $stmtProd = $conn->prepare("UPDATE products SET isActive = 0 WHERE categoryId = ?");
        $stmt->bind_param("i", $this->categoryId);
        $stmtProd->bind_param("i", $this->categoryId);
        $stmt->execute();
        $stmtProd->execute();
        $stmt->close();
        $stmtProd->close();
    }

    public static function deleteMultiple($ids)
    {
        $conn = Model::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("UPDATE categories SET isActive = 0 WHERE categoryId IN ($in)");
        $stmtProd = $conn->prepare("UPDATE products SET isActive = 0 WHERE categoryId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmtProd->bind_param($types, ...$ids);
        $stmt->execute();
        $stmtProd->execute();
        $stmt->close();
        $stmtProd->close();
    }
}