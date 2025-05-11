<?php
include_once "Controllers/Controller.php";
include_once "Models/User.php";

class UserController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } else {
            if (!isset($_SESSION['token'])) {
                header("Location: ../login/login");
                exit;
            } else {
                $userId = $_SESSION['user_id'];
                $path = $_SERVER['SCRIPT_NAME'];
                $action = $_GET['action'] ?? "list";
                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

                if (!User::checkRight($userId, 'User', 'list')) {
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } else {
                    if ($action === "list") {
                        $keyword = trim($_GET['search'] ?? '');
                        $sort = $_GET['sort'] ?? 'username';
                        $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                        $users = User::list($keyword, $sort, $dir);
                        $canAdd = User::checkRight($_SESSION['user_id'], 'User', 'add');
                        $canUpdate = User::checkRight($_SESSION['user_id'], 'User', 'update');
                        $canDelete = User::checkRight($_SESSION['user_id'], 'User', 'delete');

                        $this->render("user", "list", [
                            'users' => $users,
                            'canAdd' => $canAdd,
                            'canUpdate' => $canUpdate,
                            'canDelete' => $canDelete,
                        ]);
                    } elseif ($action === "delete") {
                        $ids = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
                        if (!empty($ids)) {
                            User::delete(array_map('intval', $ids));
                        }
                        $newURL = dirname($path) . "/user/list";
                        header("Location:" . $newURL);
                        exit;
                    } elseif ($action === "update") {
                        $user = new User($id);
                        $canChangeRole = ($_SESSION['user_id'] !== $id);

                        $user->role = User::getRole($id);
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (!$canChangeRole) {
                                unset($_POST['role']);
                            }
                            $user->update($_POST);
                            $newURL = dirname($path) . "/user/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $this->render("shared", "update", [
                                'user' => $user,
                                'canChangeRole' => $canChangeRole
                            ]);
                        }
                        } elseif ($action === "add") {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            User::add($_POST);
                            $newURL = dirname($path) . "/user/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $groups = User::getAllGroups();
                            $this->render("shared", "add", ['groups' => $groups]);
                        }
                    }
                }
            }
        }
    }
}



