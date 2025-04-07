<?php

include_once "Controllers/Controller.php";
include_once "Models/Product.php";

class ProductController  extends Controller {
    function route()
    {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';

        if ($action == 'list') {
            $data = Product::list();
            this->render("Product", "products", $data);
        }
    }
}

?>