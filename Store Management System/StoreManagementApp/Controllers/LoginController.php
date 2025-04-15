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
        cdebug(dirname($path));
        cdebug($action,"action");
        //cdebug($_GET['action'], "true action in logincontr");
        //exit;

        if ($action === "login") {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {  //(!empty($_POST['username']) && !empty($_POST['password'])) 
                $this->processLogin();
            } else {
                $this->render("Login", "login");
            }
        } else {
            //logout functionality
        }

        // if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
        //     cdebug($_SESSION,'logged IN SUCCESSFUL');
        //     include "Views/$controller/$view.php";
        //     $newUrl = dirname($path);
        //     header("Location: " . $newUrl);
        // }
        // elseif (!empty($_POST) && User::verifyLogin()){
        //     $_SESSION['loggedIn'] = true;
        //     $newUrl = dirname($path) . "/home";
        //     header("Location: " .$newUrl);
    
        // }
        // elseif ($action == "login") {
        //     include "Views/login/login.php";
        // }

    }


    function processLogin() {
        $loginData = User::verfifyLoginForm();
        if ($loginData['return'] == true) {
            $_SESSION['userId'] = $loginData['user']->id;
            $_SESSION['token'] = bin2hex(random_bytes(16)); // Generate a random session token
            header("Location: " . dirname($path) . "/home");
            cdebug($_SESSION,'SUCCESSS');
        } else {
            header("Location: " . dirname($path) . "/login");
        }
    }

    // THAO code
    // private function processLogin() {
    //     $conn = Model::connect();
    //     $sql = "SELECT * FROM `users` WHERE `username` = ? AND `isActive` = 1";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("s", $_POST['username']);
    //     $stmt->execute();

    //     $result = $stmt->get_result();
    //     $user = $result->fetch_object();

    //     if ($user && sha1($_POST['password']) === $user->password) {
    //         session_start();
    //         $_SESSION['user_id'] = $user->id;
    //         $_SESSION['token'] = bin2hex(random_bytes(16)); // Generate a random session token
    //         header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/home");
    //     } else {
    //         header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login");
    //     }
    // }

    
    



}



