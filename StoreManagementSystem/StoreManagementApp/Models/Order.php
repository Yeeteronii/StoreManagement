<?php
include_once "Model.php";

class Order extends Model
{
    public $orderId;
    public $productId;
    public $orderDate;
    public $quantity;
    public $categoryName;
    public $productName;

    function __construct($param = null)
    {
        if (is_object($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = Model::connect();
            $stmt = $conn->prepare("SELECT p.productName, c.categoryName, o.orderDate, o.quantity
FROM orders o
JOIN products p ON o.productId = p.productId
JOIN categories c ON p.categoryId = c.categoryId");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            if ($row) $this->setProperties($row);
        }
    }

    private function setProperties($row)
    {
        $this->orderDate = $row->orderDate;
        $this->quantity = $row->quantity;
        $this->categoryName = $row->categoryName;
        $this->productName = $row->productName;
    }

    public static function list()
    {
        $list = [];
        $sql = "SELECT p.productName, c.categoryName, o.orderDate, o.quantity 
                    FROM orders o 
                    JOIN products p ON o.productId = p.productId 
                    JOIN categories c ON p.categoryId = c.categoryId";
        $conn = Model::connect();
        $result = $conn->query($sql);
        while ($row = $result->fetch_object()) {
            $list[] = new Product($row);
        }
        return $list;
    }

    public static function getAllCategories()
    {
        $conn = Model::connect();
        $sql = "SELECT categoryName FROM categories";
        $result = $conn->query($sql);
        $categories = [];
        while ($row = $result->fetch_object()) {
            $categories[] = $row->categoryName;
        }
        return $categories;
    }

    public function incrementQuantity()
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE orders SET quantity = quantity + 1 WHERE orderId = ?");
        $stmt->bind_param("i", $this->orderId);
        $stmt->execute();
        $stmt->close();
    }

    public function decrementQuantity()
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("UPDATE orders SET quantity = GREATEST(quantity - 1, 0) WHERE OrderId = ?");
        $stmt->bind_param("i", $this->orderId);
        $stmt->execute();
        $stmt->close();
    }

    public static function listFilteredSorted($keyword, $category, $sort, $dir)
    {
        $allowedSorts = ['productName', 'categoryName', 'orderDate', 'quantity'];
        if (!in_array($sort, $allowedSorts)) $sort = 'productName';
        $dir = ($dir === 'DESC') ? 'DESC' : 'ASC';

        $conn = Model::connect();

        $sql = "SELECT p.productName, c.categoryName, o.orderDate, o.quantity
FROM orders o
JOIN products p ON o.productId = p.productId
JOIN categories c ON p.categoryId = c.categoryId";

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
            $list[] = new Order($row);
        }
        $stmt->close();
        return $list;
    }

    public function delete()
    {
        $conn = Model::connect();
        $stmt = $conn->prepare("DELETE FROM orders WHERE orderId = ?");
        $stmt->bind_param("i", $this->orderId);
        $stmt->execute();
    }

    public static function deleteMultiple($ids)
    {
        $conn = Model::connect();
        $in = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $conn->prepare("DELETE FROM order WHERE orderId IN ($in)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
    }
}