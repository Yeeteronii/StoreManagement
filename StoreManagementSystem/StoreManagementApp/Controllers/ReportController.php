<?php
include_once "Controllers/Controller.php";
include_once "Models/Report.php";
include_once "Models/User.php";

class ReportController extends Controller
{
    public function route()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } else {
            $userId = $_SESSION['user_id'];
            $path = $_SERVER['SCRIPT_NAME'];
            if (!isset($_SESSION['token'])) {
                header("Location: /login/login");
                exit;
            } elseif (!User::checkRight($userId, 'Report', 'list')) {
                $newURL = dirname($path) . "/product/list";
                header("Location:" . $newURL);
                exit;
            } else {
                $action = $_GET['action'] ?? "list";
                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

                if ($action === "list") {
                    $sort = $_GET['sort'] ?? 'date';
                    $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                    $reports = Report::listFilteredSorted($sort, $dir);


                    $canAdd = User::checkRight($_SESSION['user_id'], 'Report', 'add');
                    $canUpdate = User::checkRight($_SESSION['user_id'], 'Report', 'update');
                    $canDelete = User::checkRight($_SESSION['user_id'], 'Report', 'delete');
                    $canViewDeleted = User::checkRight($_SESSION['user_id'], 'Report', 'viewDeleted');
                    $canRestore = User::checkRight($_SESSION['user_id'], 'Report', 'restore');

                    $this->render("report", "list", [
                        'report' => $reports,
                        'canAdd' => $canAdd,
                        'canUpdate' => $canUpdate,
                        'canDelete' => $canDelete,
                        'canViewDeleted' => $canViewDeleted,
                        'canRestore' => $canRestore
                    ]);
                } elseif ($action === "add") {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        Report::add($_POST);
                        $newURL = dirname($path) . "/report/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $this->render("shared", "add");
                    }
                } elseif ($action === "update") {
                    $report = new Report($id);
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $report->update($_POST);
                        $newURL = dirname($path) . "/report/list";
                        header("Location:" . $newURL);
                        exit;
                    } else {
                        $this->render("shared", "update", ['report' => $report]);
                    }

                } elseif ($action === "delete") {
                    $ids = $_POST['delete_ids'] ?? [];
                    if (!empty($ids)) {
                        Report::delete(array_map('intval', $ids));
                    }
                    $newURL = dirname($path) . "/report/list";
                    header("Location:" . $newURL);
                    exit;

                } elseif ($action === "viewDeleted") {
                    $report = Report::viewDeleted();

                    $this->render("report", "viewDeleted", [
                        'report' => $report
                    ]);
                } elseif ($action === "restore") {
                    if ($id > 0) {
                        Report::restore($id);
                    }
                    $newURL = dirname($path) . "/report/viewDeleted";
                    header("Location:" . $newURL);
                    exit;
                }

            }
        }
    }
}