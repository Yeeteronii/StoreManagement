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

    public static function listFilteredSorted($keyword, $sort, $dir)
    {
        $allowedSorts = ['categoryName', 'categoryTax'];
        if (!in_array($sort, $allowedSorts)) $sort = 'categoryName';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();
        $sql = "SELECT * FROM categories WHERE isActive = 1";

        $params = [];
        $types = '';

        if (!empty($keyword)) {
            $sql .= " AND categoryName LIKE ?";
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
            $list[] = new Category($row);
        }
        $stmt->close();
        return $list;
    }


    public static function add($data)
    {
        if ($data['categoryTax'] < 0) {
            throw new Exception("Category Tax must be a non-negative number.");
        }

        $conn = Model::connect();
        $sql = "INSERT INTO categories (categoryName, categoryTax, isActive) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sd", $data['categoryName'], $data['categoryTax']);
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        if ($data['categoryTax'] < 0) {
            throw new Exception("Category Tax must be a non-negative number.");
        }

        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE categories SET categoryName = ?, categoryTax = ? WHERE categoryId = ?");
        $stmt->bind_param("sdi", $data['categoryName'], $data['categoryTax'], $this->categoryId);
        $stmt->execute();
        $stmt->close();
    }


    public static function delete($ids)
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

    public static function viewDeleted()
    {
        $conn = Model::connect();
        $sql = "SELECT * FROM categories WHERE isActive = 0";
        $result = $conn->query($sql);

        $list = [];
        while ($row = $result->fetch_object()) {
            $category = new Category($row);
            $list[] = $category;
        }
        return $list;
    }

    public static function restore($id)
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE categories SET isActive = 1 WHERE categoryId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}