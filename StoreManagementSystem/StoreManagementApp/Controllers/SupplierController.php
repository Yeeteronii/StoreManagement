<?php
include_once "Controllers/Controller.php";
include_once "Models/Supplier.php";
include_once "Models/User.php";

class SupplierController extends Controller
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
                 if (!User::checkRight($userId, 'Supplier', 'list')) {
                    $newURL = dirname($path) . "/product/list";
                    header("Location:" . $newURL);
                    exit;
                } else {
                    if ($action === "list") {
                        $keyword = trim($_GET['search'] ?? '');
                        $sort = $_GET['sort'] ?? 'supplierName';
                        $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                        $suppliers = Supplier::listFilteredSorted($keyword, $sort, $dir);


                        $canAdd = User::checkRight($_SESSION['user_id'], 'Report', 'add');
                        $canUpdate = User::checkRight($_SESSION['user_id'], 'Report', 'update');
                        $canDelete = User::checkRight($_SESSION['user_id'], 'Report', 'delete');
                        $canViewDeleted = User::checkRight($_SESSION['user_id'], 'Report', 'viewDeleted');

                        $this->render("supplier", "list", [
                            'suppliers' => $suppliers,
                            'search' => $keyword,
                            'canAdd' => $canAdd,
                            'canUpdate' => $canUpdate,
                            'canDelete' => $canDelete,
                            'canViewDeleted' => $canViewDeleted,
                        ]);
                    } elseif ($action === "add") {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            Supplier::add($_POST);
                            $newURL = dirname($path) . "/supplier/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $this->render("shared", "add");
                        }
                    } elseif ($action === "update") {
                        $supplier = new Supplier($id);
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $supplier->update($_POST);
                            $newURL = dirname($path) . "/supplier/list";
                            header("Location:" . $newURL);
                            exit;
                        } else {
                            $this->render("shared", "update", ['supplier' => $supplier]);
                        }

                    } elseif ($action === "delete") {
                        $ids = $_POST['delete_ids'] ?? [];
                        if (!empty($ids)) {
                            Supplier::delete(array_map('intval', $ids));
                        }
                        $newURL = dirname($path) . "/supplier/list";
                        header("Location:" . $newURL);
                        exit;

                    } elseif ($action === "viewDeleted") {
                        $suppliers = Supplier::viewDeleted();
                        $canRestore = User::checkRight($_SESSION['user_id'], 'Report', 'restore');
                        $this->render("supplier", "viewDeleted", [
                            'suppliers' => $suppliers,
                            'canRestore' => $canRestore
                        ]);
                    } elseif ($action === "restore") {
                        if ($id > 0) {
                            Supplier::restore($id);
                        }
                        $newURL = dirname($path) . "/supplier/viewDeleted";
                        header("Location:" . $newURL);
                        exit;
                    }

                }
            }
        }
    }
}