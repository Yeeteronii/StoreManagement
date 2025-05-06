<?php
include_once "Controllers/Controller.php";
include_once "Models/Product.php";

class ProductController extends Controller
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
            header("Location: /login/login");
            exit;
        }

        if ($action === "list") {
            $keyword = trim($_GET['search'] ?? '');
            $category = trim($_GET['category'] ?? '');
            $sort = $_GET['sort'] ?? 'productName';
            $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

            $categories = Product::getAllCategories();
            $products = Product::listFilteredSorted($keyword, $category, $sort, $dir);

            $this->render("product", "list", [
                'products' => $products,
                'search' => $keyword,
                'category' => $category,
                'categories' => $categories
            ]);

        } elseif ($action === "add") {
            if ($_SESSION['role'] !== 'admin') {
                header("Location:" . dirname($path) . "/login/login");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                Product::add($_POST);
                header("Location:" . dirname($path) . "/product/list");
                exit;
            } else {
                $this->render("shared", "add");
            }

        } elseif ($action === "update") {
            $product = new Product($id);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $product->update($_POST);
                header("Location:" . dirname($path) . "/product/list");
                exit;
            } else {
                $this->render("shared", "update", ['product' => $product]);
            }

        } elseif ($action === "delete") {
            $product = new Product($id);
            $product->delete();
            header("Location:" . dirname($path) . "/product/list");
            exit;

        } elseif ($action === "deleteMultiple") {
            $ids = $_POST['delete_ids'] ?? [];
            if (!empty($ids)) {
                Product::deleteMultiple(array_map('intval', $ids));
            }
            header("Location:" . dirname($path) . "/product/list");
            exit;

        } elseif ($action === "addToOrder") {
            $product = new Product($id);
            if ($product) {
                Product::addToOrder($product->productId);
            }
            header("Location:" . dirname($path) . "/product/list");
            exit;
        }
    }
}