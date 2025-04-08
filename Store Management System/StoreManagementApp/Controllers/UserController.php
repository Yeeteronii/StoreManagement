<?php

include_once "Controllers/Contrller.php";
include_once "Models/User.php";

class UserController extends Controller {

    function route() {
        $path = $_SERVER['SCRIPT_NAME'];
		$action = isset($_GET['action']) ? $_GET['action'] : "list";
		$id = isset($_GET['id']) ? intval($_GET['id']) : -1;


        



    }

}













