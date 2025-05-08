<?php
include_once "Controllers/Controller.php";
include_once "Models/Product.php";
include_once "Models/User.php";

class ProductController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } else {
            if (!isset($_SESSION['token'])) {
                header("Location: /login/login");
                exit;
            } else {
                $userId = $_SESSION['user_id'];
                $path = $_SERVER['SCRIPT_NAME'];
                $action = $_GET['action'] ?? "list";
                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

                if ($action === "list") {
                    $keyword = trim($_GET['search'] ?? '');
                    $category = trim($_GET['category'] ?? '');
                    $sort = $_GET['sort'] ?? 'productName';
                    $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                    $categories = Product::getAllCategories();
                    $products = Product::listFilteredSorted($keyword, $category, $sort, $dir);


                    $canAdd = User::checkRight($_SESSION['user_id'], 'Product', 'add');
                    $canUpdate = User::checkRight($_SESSION['user_id'], 'Product', 'update');
                    $canDelete = User::checkRight($_SESSION['user_id'], 'Product', 'delete');
                    $canOrder = User::checkRight($_SESSION['user_id'], 'Product', 'order');
                    $canCategory = User::checkRight($_SESSION['user_id'], 'Product', 'Category');
                    $canViewDeleted = User::checkRight($_SESSION['user_id'], 'Product', 'viewDeleted');
                    $canRestore = User::checkRight($_SESSION['user_id'], 'Product', 'restore');

                    $this->render("product", "list", [
                        'products' => $products,
                        'search' => $keyword,
                        'category' => $category,
                        'categories' => $categories,
                        'canAdd' => $canAdd,
                        'canUpdate' => $canUpdate,
                        'canDelete' => $canDelete,
                        'canOrder' => $canOrder,
                        'canCategory' => $canCategory,
                        'canViewDeleted' => $canViewDeleted,
                        'canRestore' => $canRestore
                    ]);
                } elseif ($action === "add") {
                    if (!User::checkRight($userId, 'Product', 'add')) {
                        $newURL = dirname($path) . "/product/list";
                        header("Location:" . $newURL);
                        exit;
                    }
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        Product::add($_POST);
                        $newURL = dirname($path) . "/product/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $categories = Product::getAllCategories();
                        $this->render("shared", "add", [
                            'categories' => $categories
                        ]);
                    }
                } elseif ($action === "update") {
                    $product = new Product($id);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $product->update($_POST);
                        $newURL = dirname($path) . "/product/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $this->render("shared", "update", ['product' => $product]);
                    }

                } elseif ($action === "delete") {
                    $ids = $_POST['delete_ids'] ?? [];
                    if (!empty($ids)) {
                        Product::delete(array_map('intval', $ids));
                    }
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;

                } elseif ($action === "addToOrder") {
                    $product = new Product($id);
                    if ($product) {
                        Product::addToOrder($product->productId);
                    }
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } elseif ($action === "category") {
                    if (!User::checkRight($userId, 'Product', 'category')) {
                        $newURL = dirname($path) . "/product/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $this->render("category", "list");
                    }
                } elseif ($action === "viewDeleted") {
                    $products = Product::viewDeleted();

                    $this->render("product", "viewDeleted", [
                        'products' => $products
                    ]);
                } elseif ($action === "restore") {
                    if ($id > 0) {
                        Product::restore($id);
                    }
                    $newURL = dirname($path) . "/product/viewDeleted";
                    header("Location:" . $newURL);
                    exit;
                }

            }
        }
    }
}