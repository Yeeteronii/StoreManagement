<?php
include_once "Controllers/Controller.php";
include_once "Models/User.php";

cdebug($_SESSION);

class SettingsController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } else {
            $userId = $_SESSION['user_id'];
            $path = $_SERVER['SCRIPT_NAME'];
            $action = $_GET['action'] ?? "list";
            $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
            if (!isset($_SESSION['token'])) {
                header("Location: /login/login");
                exit;
            } else {
                if ($action === "list") {
                    $userData = new User($_SESSION['user_id']);

                    $this->render("settings", "list", [
                        'user' => $userData,
                    ]);
                } elseif ($action === "update") {
                    $shift = new Shift($id);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $shift->update($_POST);
                        $newURL = dirname($path) . "/shift/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $users = User::listFilteredSorted('', 'username', 'ASC');
                        $this->render("shared", "update", ['shift' => $shift,
                            'role' => $_SESSION['role'],
                            'users' => $users]);
                    }

                } elseif ($action === "delete") {
                    if ($id > 0) {
                        Shift::delete($id);
                    }
                    $newURL = dirname($path) . "/shift/list";
                    header("Location:" . $newURL);
                    exit;
                }
            }
        }
    }
}