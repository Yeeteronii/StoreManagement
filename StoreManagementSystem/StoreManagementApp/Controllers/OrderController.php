<?php
include_once "Controllers/Controller.php";
include_once "Models/Order.php";

class OrderController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $path = $_SERVER['SCRIPT_NAME'];
        $action = $_GET['action'] ?? "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if (!isset($_SESSION['token'])) {
            header("Location: ../login/login");
            exit;
        }
        if ($action === "list") {
            $keyword = trim($_GET['search'] ?? '');
            $category = trim($_GET['category'] ?? '');
            $sort = $_GET['sort'] ?? 'productName';
            $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

            $categories = Order::getAllCategories();
            $orders = Order::listFilteredSorted($keyword, $category, $sort, $dir);

            $this->render("order", "list", [
                'orders' => $orders,
                'search' => $keyword,
                'category' => $category,
                'categories' => $categories
            ]);
        } elseif ($action === "delete") {
            $order = new Order($id);
            $order->delete();
            header("Location:" . dirname($path) . "/order/list");
            exit;
        } elseif ($action === "deleteMultiple") {
            $ids = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
            if (!empty($ids)) {
            Order::deleteMultiple(array_map('intval', $ids));
            }
            header("Location:" . dirname($path) . "/order/list");
            exit;
        } elseif ($action === "updateQuantity") {
            $order = new Order($id);
            $change = $_GET['change'] ?? '';

            if ($change === 'up') {
                $order->incrementQuantity();
            } elseif ($change === 'down') {
                $order->decrementQuantity();
            }

            header("Location:" . dirname($path) . "/order/list");
            exit;
        }
    }
}



