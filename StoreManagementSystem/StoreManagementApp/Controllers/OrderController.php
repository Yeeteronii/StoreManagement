<?php
include_once "Controllers/Controller.php";
include_once "Models/Order.php";
include_once "Models/User.php";

class OrderController extends Controller
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
                $id = isset($_POST['orderId']) ? intval($_POST['orderId']) : (isset($_GET['id']) ? intval($_GET['id']) : -1);

                if (!User::checkRight($userId, 'Order', 'list')) {
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } else {
                    if ($action === "list") {
                        $keyword = trim($_GET['search'] ?? '');
                        $category = trim($_GET['category'] ?? '');
                        $sort = $_GET['sort'] ?? 'productName';
                        $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                        $categories = Order::getAllCategories();
                        $orders = Order::listFilteredSorted($keyword, $category, $sort, $dir);
                        $canAdd = User::checkRight($_SESSION['user_id'], 'Order', 'add');
                        $canUpdate = User::checkRight($_SESSION['user_id'], 'Order', 'update');
                        $canDelete = User::checkRight($_SESSION['user_id'], 'Order', 'delete');
                        $canOrder = User::checkRight($_SESSION['user_id'], 'Order', 'order');

                        $this->render("order", "list", [
                            'orders' => $orders,
                            'search' => $keyword,
                            'category' => $category,
                            'categories' => $categories,
                            'canAdd' => $canAdd,
                            'canUpdate' => $canUpdate,
                            'canDelete' => $canDelete,
                            'canOrder' => $canOrder
                        ]);
                    } elseif ($action === "delete") {
                        $ids = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
                        if (!empty($ids)) {
                            Order::delete(array_map('intval', $ids));
                        }
                        $newURL = dirname($path) . "/order/list";
                        header("Location:" . $newURL);
                        exit;
                    } elseif ($action === "update") {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
                            Order::update($_POST['quantity']);
                        }
                        $newURL = dirname($path) . "/order/list";
                        header("Location:" . $newURL);
                        exit;
                    }
                }
            }
        }
    }
}



