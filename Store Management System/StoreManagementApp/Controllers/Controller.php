<?php
//cdebug(1);
//exit;

include_once 'Models/Model.php';

class Controller {
    
    function route(){
	}

    function render($controller, $view, $data = []) {
        $path = $_SERVER['SCRIPT_NAME'];

        if ($controller == "User" && $view == "add") {
            ///WARNING INCLUDE DATA FOR SPECIFIED ADD (user in this case)!!!!!!!!!!!!!!!!!!!!!!
            include "Views/add.php";
        } 
        elseif(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            extract($data);
            include "Views/$controller/$view.php";

        } 
        elseif (!empty($_POST) && User::verifyLogin()){
            $_SESSION['loggedIn'] = true;
            $newUrl = dirname($path) . "/home";
            header("Location: " .$newUrl);
    
        } else {
            include "Views/login.php";
        }

        
    }

}




