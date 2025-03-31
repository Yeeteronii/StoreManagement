<?php

include_once "Models/Model.php";

class Product {
    public $productId;
    public $productName;
    public $buyPrice;
    public $sellingPrice;
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
        $this->buyPrice = $param->buyPrice;
        $this->sellingPrice = $param->sellingPrice;
        $this->categoryId = $param->categoryId;
        $this->threshold = $param->threshold;
        $this->quantity = $param->quantity;
    }

}