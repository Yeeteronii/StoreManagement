<?php

include_once "Controllers/Controller.php";
include_once "Models/category.php";

class CategoryController extends Controller
{
    function route()
    {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

//        if (User::checkIfLoggedIn()) {
        if ($action == 'list') {
            $data = Category::list();
            $this->render("category", "categories", $data);
        } else if ($action == 'add') {

        } else if ($action == 'edit') {

        } else if ($action == 'delete') {

        }
//        } else {
        //FWD TO ACCESS DENIED BC FWD TO LOGIN IS HANDLED IN CHECKLOGIN FUCNTION
//            exit; //temp
//        }

    }
}

