<?php

include_once "Controllers/Controller.php";
include_once "Models/Order.php";

class OrderController extends Controller {
    function route()
    {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        cdebug($action, "setting action in prodcontr");
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

//        if (User::checkIfLoggedIn()) {
            if ($action == 'list') {
                $data = Order::list();
                $this->render("Order", "orders", $data);
            } else if ($action == 'view') {
                $data = Order::view($id);
                $this->render("Order", "view", $data);
            }
//        } else {
            //FWD TO ACCESS DENIED BC FWD TO LOGIN IS HANDLED IN CHECKLOGIN FUCNTION
            exit; //temp
//        }
            
    }
}

?>