<?php


class Controller {

    function route() {}

    function render($controller, $action, $data = []) {
        $path = $_SERVER['SCRIPT_NAME'];

        include_once "Models/User.php";

        // Adding a new user bypass
        if ($controller == "User" && $action == "add") {
            include "Views/User/add.php";
        } 

        // Check if logged in
        //logged in
        elseif(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            extract($data);
            if ($action == 'add' || ) {

            } elseif ($action == 'list') {
                include "Views/$controller/$action.php";
            }

        } 
        //user freshly logged in, setting loggedIn to true
        elseif (!empty($_POST) && User::verifyLogin()){
            $_SESSION['loggedIn'] = true;
            $newUrl = dirname($path) . "/home";
            header("Location: " .$newUrl);

        }
        //simply display login
        else {
            include "Views/login.php";
        }


        

        
    }





















}





