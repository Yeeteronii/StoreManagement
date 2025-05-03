<?php
    
include_once "Models/Model.php";

class Order extends Model{

    public $orderId;
    public $productId;
    public $orderDate;
    public $quantity;

    public $productName;

    function __construct($param = null){
        if(is_object($param)){
            $this->setProperties($param);
        }
        elseif(is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT *
                        FROM `orders` AS `o`
                        WHERE o.orderId = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", ($param));
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_object();
            $this->setProperties($row);

        }
    }

    private function setProperties($param) {
        $this->orderId = $param->orderId;
        $this->productId = $param->productId;
        $this->orderDate = $param->orderDate;
        $this->quantity = $param->quantity;
        $this->productName = $param->productName;
    }


    public static function list() {
        $list = [];
        $conn = Model::connect();
        $sql = "SELECT o.*, p.`productName` FROM `orders` o JOIN `products` p ON o.`productId` = p.`productId` WHERE o.`quantity` > 0;";

        $result = $conn->query($sql);
        while($row = $result->fetch_object()) {
            $product = new Order($row);
            array_push($list, $product);
        }
        return $list;
    }







}