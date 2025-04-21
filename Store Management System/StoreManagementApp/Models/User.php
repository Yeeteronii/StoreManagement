<?php
    
    include_once "Models/Model.php";

    class User extends Model{
    
        public $userId;
        public $username;
        public $password;
    
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
            $this->password = $param->password;
    
        }






    //Change based on chosen encryption method
    //and maybe also using 2fa but that shit is too har T.T
    //whats the point of tokens
    public static function verifyLoginForm() {
        $conn = Model::connect();
        $sql = "SELECT *
            FROM `users`
            WHERE username = ?
            AND password = ?
            LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", ($_POST['username']), $_POST['password']);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_object();

        // return outcome and user
        // use: $data['return']
        if (!empty($row)) {
            //$_SESSION['loggedIn'] = true;
            //$_SESSION['token'] = Model::generateRandomString(36);
            $data['return'] = true;
            $data['user'] = $row;
            return $data;
        } else {
            $data['return'] = false;
            return $data;
        }

        // if (!empty($row)) {
        //         //$_SESSION['loggedIn'] = true;
        //         //$_SESSION['token'] = Model::generateRandomString(36);
        //         return true;
        //     } else {
        //         return false;
        //     }
    }


    public static function checkIfLoggedIn() {
        //cdebug(dirname($_SERVER['SCRIPT_NAME']) . "/login");
        //exit;
        cdebug($_GET['action'], "action in checked logged in");
        if(!empty($_SESSION['userId'])) {
            return true;
        } else {
            header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login");
        }
    }



    //OLD VERFIYLOGIN
    // public static function verifyLogin() {
    //         $conn = Model::connect_users();
    //         $sql = "SELECT *
    //             FROM `users`
    //             WHERE username = ?
    //             AND password = ?";

    //         $stmt = $conn->prepare($sql);
    //         $encryptedPassword = sha1($_POST['password']); 
    //         $stmt->bind_param("ss", ($_POST['username']), $encryptedPassword);
    //         $stmt->execute();


    //         $result = $stmt->get_result();
    //         $row = $result->fetch_object();


    //         if (!empty($row)) {
    //             $_SESSION['loggedIn'] = true;
    //             //$_SESSION['token'] = Model::generateRandomString(36);
    //             return true;
    //         } else {
    //             return false;
    //         }

    //     }


    // }


}