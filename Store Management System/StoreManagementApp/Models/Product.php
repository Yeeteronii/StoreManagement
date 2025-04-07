<?php

include_once "Models/Model.php";

class Product {
    public $productId;
    public $productName;
    public $cost;
    public $priceToSell;
    public $categoryId;
    public $threshold;
    public $quantity;

    function __construct($param = null)
    {
        if(is_object($param)){

            $this->setProperties($param);
        }
        elseif(is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM `products` WHERE `productId` = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("i", $param);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_object();

            $this->setProperties($row);
        }
    }

    private function setProperties($param){
        $this->productId = $param->productId;
        $this->productName = $param->productName;
        $this->cost = $param->cost;
        $this->priceToSell = $param->priceToSell;
        $this->categoryId = $param->categoryId;
        $this->threshold = $param->threshold;
        $this->quantity = $param->quantity;
    }
    public static function list() {
        $list = [];
        $conn = Model::connect();
        $sql = "SELECT p.`productName`, p.`cost`, p.`priceToSell`, c.`categoryName`, p.`quantity` FROM `products` p JOIN `categories` c ON c.`categoryId` = p.`categoryId` WHERE p.`isActive` = 1;";

        $result = $conn->query($sql);
        while($row = $result->fetch_object()) {
            $product = new Product($row);
            array_push($list, $product);
        }
        return $list;
    }

    public static function view($productId = -1)
    {
        $list = [];
        $sql = "SELECT * FROM `products` WHERE `productId`  = " . $productId . " LIMIT 1";

        $conn = Model::connect();
        $result = $conn->query($sql);

        $row = $result->fetch_object();
        $product = new Product($row);
        array_push($list, $product);

        return $list;
    }





}