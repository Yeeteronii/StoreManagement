<?php

include_once "Controllers/Controller.php";
include_once "Models/User.php";

class LoginController extends Controller {

    function route() {
        $path = $_SERVER['SCRIPT_NAME'];
		$action = isset($_GET['action']) ? $_GET['action'] : "login";
		//$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        cdebug($_SESSION,'session in login controllr');
        cdebug($_POST,'post in login controller');
        cdebug(User::verifyLoginForm(),'verfiylogin in login control');
        cdebug(dirname($path),'dirname($path)');
        cdebug($action,"action");
        //cdebug($_GET['action'], "true action in logincontr");
        //exit;

        if ($action === "login") {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {  //(!empty($_POST['username']) && !empty($_POST['password'])) 
                if($this->processLogin()) {
                    header("Location: " . dirname($path) . "/product");
                } else {
                    $this->render("Login", "login");
                }
                cdebug('post WORKING!!!!!!');
                //exit;
            } else {
                $this->render("Login", "login");
                cdebug('post not setting');
                //exit;
            }
        } else {
            //logout functionality
        }


    }


    function processLogin() {
        $loginData = User::verifyLoginForm();
        if ($loginData['return'] == true) {
            $_SESSION['userId'] = $loginData['user']->id;
            $_SESSION['token'] = bin2hex(random_bytes(16)); // Generate a random session token
            return true;
        } else {
            return false;
        }
    }


    
    



}



