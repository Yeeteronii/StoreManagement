<?php

include_once "Controllers/Controller.php";
include_once "Models/User.php";

class LoginController extends Controller {

    function route() {
        $path = $_SERVER['SCRIPT_NAME'];
		$action = isset($_GET['action']) ? $_GET['action'] : "login";
		//$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        cdebug($_SESSION,'session in login controllr');

        if ($action == "login") {
            include "Views/login/login.php";
        }



    }

    
    



}



