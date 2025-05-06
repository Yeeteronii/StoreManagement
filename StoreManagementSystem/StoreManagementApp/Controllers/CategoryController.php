<?php

include_once "Controllers/Controller.php";
include_once "Models/Category.php";

class CategoryController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $path = $_SERVER['SCRIPT_NAME'];
        $action = $_GET['action'] ?? "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if ($_SESSION['role'] !== 'admin') {
                header("Location:" . dirname($path) . "/login/login");
                exit;
            } else {
                if ($action === "list") {
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'categoryName';
                    $dir = (isset($_GET['dir']) ? $_GET['dir'] : 'asc') === 'desc' ? 'DESC' : 'ASC';
                    $categories = Category::listFilteredSorted($sort, $dir);

                    $this->render("category", "list", [
                        'categories' => $categories
                    ]);
                } elseif ($action === "add") {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        Category::add($_POST);
                        header("Location:" . dirname($path) . "/category/list");
                        exit;
                    } else {
                        $this->render("shared", "add");
                    }
                } elseif ($action === "update") {
                    $category = new Category($id);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $category->update($_POST);
                        header("Location:" . dirname($path) . "/category/list");
                        exit;
                    } else {
                        $this->render("shared", "update", ['category' => $category]);
                    }
                } elseif ($action === "delete") {
                    $category = new Category($id);
                    $category->delete();
                    header("Location:" . dirname($path) . "/category/list");
                    exit;
                } elseif ($action === "deleteMultiple") {
                    $ids = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
                    if (!empty($ids)) {
                        Category::deleteMultiple(array_map('intval', $ids));
                    }
                    header("Location:" . dirname($path) . "/category/list");
                    exit;
                }
            }
        }
    }

