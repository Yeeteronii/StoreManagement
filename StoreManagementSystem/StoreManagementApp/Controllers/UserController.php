<?php
include_once "Controllers/Controller.php";
include_once "Models/User.php";

class UserController extends Controller {

    function route() {
        global $controller;
        $controller = ucfirst($controller);
        $path = $_SERVER['SCRIPT_NAME'];

        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if ($action == "login") {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $data = User::authenticate($_POST['username'], $_POST['password']);

                if (is_null($data)) {
                    $_SESSION['login_error'] = "Invalid username or password.";
                    $this->render("login", "login");
                } else {
                    $_SESSION['user_id'] = $data->id;
                    $_SESSION['token'] = bin2hex(random_bytes(16));
                    $_SESSION['role'] = User::getRole($data->id);

                    header('Location: ' . dirname($path) . "/product/list");
                    exit;
                }
            } else {
                $this->render("login", "login");
            }
        }
        elseif ($action == "create") {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                User::create($_POST['username'], $_POST['password']);
                header('Location: ' . dirname($path) . "/login/login");
                exit;
            } else {
                $this->render("login", "create");
            }
        }

        elseif ($action == "logout") {
            session_unset();
            session_destroy();
            header("Location: " . dirname($path) . "/login/login");
            exit;
        }
    }
}
