<?php

include_once "Controllers/Controller.php";
include_once "Models/Product.php";

class ProductController extends Controller {
    function route()
    {
        $path = $_SERVER['SCRIPT_NAME'];
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        cdebug($action, "setting action in prodcontr");
        cdebug($_POST, "_POST");
        // cdebug("WARNING: note that when input into the searchbar, then remove the text from the searchbar, it triggers a reload. Gang, is this intended behaviour? Also dont mind the cdebugs in the table, that is fixable");

//        if (User::checkIfLoggedIn()) {
            if ($action == 'list') {
                // Check if searchText is set
                if (isset($_POST['searchText'])) {
                    $searchText = $_POST['searchText'];

                    // Check if searchText is empty
                    if (!empty($searchText)) {
                        $data = Product::listFiltered($searchText);
                        //generate html rows for ajax response
                        $output = '';
                        foreach ($data as $product) {
                            //include a single row template for each product
                            ob_start(); // Start output buffering
                            include(__DIR__ . '/../Views/Product/_product_row.php'); // Adjust path as needed
                            $output .= ob_get_clean(); // Get the buffered output and clear the buffer
                        }
                        echo $output;
                        return;
                    } else {
                        // If searchText is empty, send an empty response to clear the table
                        echo '';
                        return;
                    }
                } else {
                    $data = Product::list();
                }
                $this->render("Product", "products", $data);
            } else if ($action == 'view') {
                $data = Product::view($id);
                $this->render("Product", "view", $data);
            } else if ($action == 'add') {
                

            } else if ($action == 'edit') {

            } else if ($action == 'delete') {
                $p = new Product($id);
                $p->delete($id);
                $newUrl = dirname($path) . "/product/list";
                header("Location: $newUrl");
            } else if( $action == "deleteMultiple"){

                if (isset($_POST['productIds']) && is_array($_POST['productIds'])) {
                    foreach ($_POST['productIds'] as $productId) {
                        $product = new Product((int)$productId);
                        $product->delete();
                    }
                }
                $newUrl = dirname($path) . "/product/list";
                header("Location: $newUrl");
                exit;
            } else if($action == "order"){
                $p = new Product($id);
                $p->order($id);
                $newUrl = dirname($path) . "/product/list";
                header("Location: $newUrl");
            } else {
                // Handle unknown action or show an error page
            }
//        } else {
            //FWD TO ACCESS DENIED BC FWD TO LOGIN IS HANDLED IN CHECKLOGIN FUCNTION
//            exit; //temp
//        }
            
    }
}

?>