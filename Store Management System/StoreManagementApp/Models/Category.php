<?php
include_once "Models/Model.php";
class Category {

    public $categoryId;
    public $categoryName;
    public $categoryTax;


    function __construct($param=null)
    {
        if(is_object($param)){

            $this->setProperties($param);
        }
        elseif(is_int($param)) {
            $conn = Model::connect();
            $sql = "SELECT * FROM `category` WHERE `categoryId` = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("i", $param);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_object();

            $this->setProperties($row);
        }
    }

    private function setProperties($param)
    {
        $this->categoryId = $param->categoryId;
        $this->categoryName = $param->categoryName;
        $this->categoryTax = $param->categoryTax;
    }

    public static function list() {
        $conn = Model::connect();
        $list = [];
        $sql = "SELECT * FROM `category` WHERE `isActive` = ?";

        $result = $conn->query($sql);
        while($row = $result->fetch_object()) {
            $category = new Category($row);
            array_push($list, $category);
        }
        return $list;

    }

    public static function view($categoryId = -1)
    {
        $list = [];
        $sql = "SELECT * FROM `category` WHERE `categoryId` = " . $categoryId . " LIMIT 1";

        $conn = Model::connect();
        $result = $conn->query($sql);

        $row = $result->fetch_object();
        $category = new Category($row);
        array_push($list, $category);

        return $list;
    }


}