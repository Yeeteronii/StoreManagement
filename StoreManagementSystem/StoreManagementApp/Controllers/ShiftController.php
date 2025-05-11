<?php
include_once "Controllers/Controller.php";
include_once "Models/Shift.php";
include_once "Models/User.php";

class ShiftController extends Controller
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
                if (!User::checkRight($userId, 'Shift', 'list')) {
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } else {
                    if ($action === "list") {
                        $shifts = Shift::list();


                        $canAdd = User::checkRight($_SESSION['user_id'], 'Shift', 'add');
                        $canUpdate = User::checkRight($_SESSION['user_id'], 'Shift', 'update');
                        $canDelete = User::checkRight($_SESSION['user_id'], 'Shift', 'delete');

                        $this->render("shift", "list", [
                            'shifts' => $shifts,
                            'canAdd' => $canAdd,
                            'canUpdate' => $canUpdate,
                            'canDelete' => $canDelete,
                        ]);
                    } elseif ($action === "add") {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                Shift::add($_POST);
                                header("Location:" . dirname($path) . "/shift/list");
                                exit;
                            } catch (Exception $e) {
                                $users = User::listFilteredSorted('', 'username', 'ASC');
                                $this->render("shared", "add", [
                                    'role' => $_SESSION['role'],
                                    'users' => $users,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        } else {
                            $users = User::listFilteredSorted('', 'username', 'ASC');
                            $this->render("shared", "add", [
                                'role' => $_SESSION['role'],
                                'users' => $users
                            ]);
                        }

                    } elseif ($action === "update") {
                        $shift = new Shift($id);
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            try {
                                $shift->update($_POST);
                                header("Location:" . dirname($path) . "/shift/list");
                                exit;
                            } catch (Exception $e) {
                                $users = User::listFilteredSorted('', 'username', 'ASC');
                                $this->render("shared", "update", [
                                    'shift' => $shift,
                                    'role' => $_SESSION['role'],
                                    'users' => $users,
                                    'error' => $e->getMessage()
                                ]);
                            }
                        } else {
                            $users = User::listFilteredSorted('', 'username', 'ASC');
                            $this->render("shared", "update", [
                                'shift' => $shift,
                                'role' => $_SESSION['role'],
                                'users' => $users
                            ]);
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
}