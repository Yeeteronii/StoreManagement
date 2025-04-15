<?php

include_once "Controllers/Controller.php";
include_once "Models/Product.php";

class ProductController extends Controller {
    function route()
    {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        cdebug($action, "setting action in prodcontr");

        if (User::checkIfLoggedIn()) {
            if ($action == 'list') {
                $data = Product::list();
                $this->render("Product", "products", $data);
            } else if ($action == 'view') {

            }
        } else {
            //FWD TO ACCESS DENIED BC FWD TO LOGIN IS HANDLED IN CHECKLOGIN FUCNTION
            exit; //temp
        }
            
    }
}

?>