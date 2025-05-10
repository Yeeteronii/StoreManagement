<?php
include_once "Model.php";

class Product extends Model
{
    public $productId;
    public $productName;
    public $categoryId;
    public $categoryName;
    public $categoryTax;
    public $cost;
    public $priceToSell;
    public $threshold;
    public $quantity;
    public $isActive;
    public $isInOrder;
    public $taxPrice;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT p.*, c.categoryName FROM products p 
                                    JOIN categories c ON p.categoryId = c.categoryId 
                                    WHERE p.productId = ? AND p.isActive = 1");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->productId = $row->productId;
        $this->productName = $row->productName;
        $this->cost = $row->cost;
        $this->priceToSell = $row->priceToSell;
        $this->categoryId = $row->categoryId;
        $this->categoryName = $row->categoryName;
        $this->categoryTax = $row->categoryTax;
        $this->threshold = $row->threshold;
        $this->quantity = $row->quantity;
        $this->isActive = $row->isActive;
        $this->taxPrice = $row->taxPrice;
    }

    public static function listFilteredSorted($keyword, $category, $sort, $dir)
    {
        $allowedSorts = ['productName', 'categoryName', 'cost', 'priceToSell', 'quantity'];
        if (!in_array($sort, $allowedSorts)) $sort = 'productName';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();
        $sql = "SELECT p.productId, p.productName, p.cost, p.priceToSell, 
                       p.categoryId, p.threshold, p.quantity, p.isActive, c.categoryName, 
                       c.categoryTax, (p.priceToSell * c.categoryTax) + p.priceToSell AS taxPrice
                FROM products p
                JOIN categories c ON c.categoryId = p.categoryId
                WHERE p.isActive = 1";
        $params = [];
        $types = '';

        if (!empty($keyword)) {
            $sql .= " AND p.productName LIKE ?";
            $params[] = '%' . $keyword . '%';
            $types .= 's';
        }
        if (!empty($category)) {
            $sql .= " AND c.categoryName = ?";
            $params[] = $category;
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
            $product = new Product($row);
            $product->isInOrder = self::isInOrder($product->productId);
            $list[] = $product;
        }
        $stmt->close();
        return $list;
    }

    public static function getAllCategories()
    {
        $conn = Model::connect();
        $sql = "SELECT categoryId, categoryName FROM categories WHERE isActive = 1";
        $result = $conn->query($sql);
        $categories = [];
        while ($row = $result->fetch_object()) {
            $categories[] = $row;
        }
        return $categories;
    }

    public static function add($data)
    {
        $conn = Model::connect();


        $stmtTax = $conn->prepare("SELECT categoryTax FROM categories WHERE categoryId = ?");
        $stmtTax->bind_param("i", $data['categoryId']);
        $stmtTax->execute();
        $result = $stmtTax->get_result();
        $row = $result->fetch_object();
        $categoryTax = $row ? $row->categoryTax : 0.0;
        $stmtTax->close();


        $sql = "INSERT INTO products (productName, cost, priceToSell, categoryId, threshold, quantity, isActive) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiii",
            $data['productName'],
            $data['cost'],
            $data['priceToSell'],
            $data['categoryId'],
            $data['threshold'],
            $data['quantity']
        );
        $stmt->execute();
        $stmt->close();
    }

    public function update($data)
    {
        $conn = Model::connect();
        $sql = "UPDATE products 
                SET productName = ?, cost = ?, priceToSell = ?, categoryId = ?, threshold = ?, quantity = ? 
                WHERE productId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sddiiii", $data['productName'], $data['cost'], $data['priceToSell'],
            $data['categoryId'], $data['threshold'], $data['quantity'], $this->productId);
        $stmt->execute();
        $stmt->close();
    }

    public static function delete($ids)
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
        $conn = Model::connect();
        $stmt = $conn->prepare("INSERT INTO orders (productId, orderDate) VALUES (?, CURDATE())");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();
    }

    public static function isInOrder($productId)
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("SELECT 1 FROM orders WHERE productId = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $isInOrder = $result->num_rows > 0;
        $stmt->close();
        return $isInOrder;
    }

    public static function viewDeleted()
    {
        $conn = Model::connect();
        $sql = "SELECT p.productId, p.productName, p.cost, p.priceToSell, 
                   p.categoryId, p.threshold, p.quantity, p.isActive, c.categoryName
                , c.categoryTax, (p.priceToSell * c.categoryTax) + p.priceToSell AS taxPrice
            FROM products p
            JOIN categories c ON c.categoryId = p.categoryId
            WHERE p.isActive = 0";
        $result = $conn->query($sql);

        $list = [];
        while ($row = $result->fetch_object()) {
            $product = new Product($row);
            $list[] = $product;
        }
        return $list;
    }

    public static function restore($id)
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE products SET isActive = 1 WHERE productId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
