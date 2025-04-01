<?php















//Change based on chosen encryption method
//and maybe also using 2fa but that shit is too har T.T
//whats the point of tokens
public static function verifyLogin() {
        $conn = Model::connect();
        $sql = "SELECT *
            FROM `users`
            WHERE user_name = ?
            AND user_password = ?";

        $stmt = $conn->prepare($sql);
        $encryptedPassword = sha1($_POST['user_password']); 
        $stmt->bind_param("ss", ($_POST['user_name']), $encryptedPassword);
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