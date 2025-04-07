<?php
    
    include_once "Models/Model.php";

    class Order extends Model{
    
        public $orderId;
        public $productId;
        public $orderDate;
        public $quantity;
    
        function __construct($param = null){
            if(is_object($param)){
                $this->setProperties($param);
            }
            elseif(is_int($param)) {
                $conn = Model::connect();
                $sql = "SELECT *
                            FROM `user` AS `u`
                            WHERE u.userId = ? LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", ($param));
                $stmt->execute();
    
                $result = $stmt->get_result();
                $row = $result->fetch_object();
                $this->setProperties($row);
    
            }
        }
    
        private function setProperties($param) {
            $this->userId = $param->userId;
            $this->username = $param->username;
            $this->userPassword = $param->userPassword;
    
        }






//Change based on chosen encryption method
//and maybe also using 2fa but that shit is too har T.T
//whats the point of tokens
public static function verifyLogin() {
        $conn = Model::connect();
        $sql = "SELECT *
            FROM `users`
            WHERE username = ?
            AND userPassword = ?";

        $stmt = $conn->prepare($sql);
        $encryptedPassword = sha1($_POST['userPassword']); 
        $stmt->bind_param("ss", ($_POST['username']), $encryptedPassword);
        $stmt->execute();


        $result = $stmt->get_result();
        $row = $result->fetch_object();


        if (!empty($row)) {
            $_SESSION['loggedIn'] = true;
            //$_SESSION['token'] = Model::generateRandomString(36);
            return true;
        } else {
            return false;
        }

    }


}