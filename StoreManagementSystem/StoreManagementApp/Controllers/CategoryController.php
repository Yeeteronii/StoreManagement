<?php
include_once "Controllers/Controller.php";
include_once "Models/Category.php";
include_once "Models/User.php";

class CategoryController extends Controller
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

                if (!User::checkRight($userId, 'Category', $action)) {
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } else {
                    if ($action === "list") {
                        $keyword = trim($_GET['search'] ?? '');
                        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'categoryName';
                        $dir = (isset($_GET['dir']) ? $_GET['dir'] : 'asc') === 'desc' ? 'DESC' : 'ASC';


                        $categories = Category::listFilteredSorted($keyword, $sort, $dir);
                        $canAdd = User::checkRight($_SESSION['user_id'], 'Category', 'add');
                        $canUpdate = User::checkRight($_SESSION['user_id'], 'Category', 'update');
                        $canDelete = User::checkRight($_SESSION['user_id'], 'Category', 'delete');
                        $canOrder = User::checkRight($_SESSION['user_id'], 'Category', 'order');
                        $canViewDeleted = User::checkRight($_SESSION['user_id'], 'Category', 'viewDeleted');
                        $canRestore = User::checkRight($_SESSION['user_id'], 'Category', 'restore');


                        $this->render("category", "list", [
                            'categories' => $categories,
                            'canAdd' => $canAdd,
                            'canUpdate' => $canUpdate,
                            'canDelete' => $canDelete,
                            'canOrder' => $canOrder,
                            'canViewDeleted' => $canViewDeleted,
                            'canRestore' => $canRestore,
                        ]);
                    } elseif ($action === "add") {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            Category::add($_POST);
                            $newURL = dirname($path) . "/category/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $this->render("shared", "add");
                        }
                    } elseif ($action === "update") {
                        $category = new Category($id);
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $category->update($_POST);
                            $newURL = dirname($path) . "/category/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $this->render("shared", "update", ['category' => $category]);
                        }
                    } elseif ($action === "delete") {
                        $ids = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
                        if (!empty($ids)) {
                            Category::delete(array_map('intval', $ids));
                        }
                        $newURL = dirname($path) . "/category/list";
                        header("Location:" . $newURL);
                        exit;
                    } elseif ($action === "viewDeleted") {
                        $category = Category::viewDeleted();

                        $this->render("category", "viewDeleted", [
                            'categories' => $category
                        ]);
                    } elseif ($action === "restore") {
                        if ($id > 0) {
                            Category::restore($id);
                        }
                        $newURL = dirname($path) . "/category/viewDeleted";
                        header("Location:" . $newURL);
                        exit;
                    }
                }
            }
        }
    }
}
