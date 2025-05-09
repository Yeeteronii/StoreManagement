<?php
include_once "Controllers/Controller.php";
include_once "Models/Report.php";
include_once "Models/User.php";
require_once __DIR__ . '/../lib/fpdf/fpdf.php';
// use \FPDF;

class ReportController extends Controller
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
            } elseif (!User::checkRight($userId, 'Report', 'list')) {
                $newURL = dirname($path) . "/product/list";
                header("Location:" . $newURL);
                exit;
            } else {
                if ($action === "list") {
                    $sort = $_GET['sort'] ?? 'date';
                    $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

                    $reports = Report::listFilteredSorted($sort, $dir);


                    $canAdd = User::checkRight($_SESSION['user_id'], 'Report', 'add');
                    $canUpdate = User::checkRight($_SESSION['user_id'], 'Report', 'update');
                    $canDelete = User::checkRight($_SESSION['user_id'], 'Report', 'delete');
                    $canViewDeleted = User::checkRight($_SESSION['user_id'], 'Report', 'viewDeleted');
                    $canDownload = User::checkRight($_SESSION['user_id'], 'Report', 'download');

                    $this->render("report", "list", [
                        'report' => $reports,
                        'canAdd' => $canAdd,
                        'canUpdate' => $canUpdate,
                        'canDelete' => $canDelete,
                        'canViewDeleted' => $canViewDeleted,
                        'canDownload' => $canDownload
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
                    $canRestore = User::checkRight($_SESSION['user_id'], 'Report', 'restore');
                    $this->render("report", "viewDeleted", [
                        'report' => $report,
                        'canRestore' => $canRestore,
                    ]);
                } elseif ($action === "restore") {
                    if ($id > 0) {
                        Report::restore($id);
                    }
                    $newURL = dirname($path) . "/report/viewDeleted";
                    header("Location:" . $newURL);
                    exit;
                } elseif ($action === "download") {
                    $sort = $_GET['sort'] ?? 'date';
                    $dir = ($_GET['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';
                    $reports = Report::listFilteredSorted($sort, $dir);

                    $this->generatePdf($reports);
                    $newURL = dirname($path) . "/report/list";
                    header("Location:" . $newURL);
                    exit;
                }
            }
        }
    }
    private function generatePdf($reports)
    {

        $pdf = new FPDF();
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 12);

        $colWidths = [
            'date' => 30,
            'earnings' => 30,
            'profits' => 30,
            'description' => 90
        ];

        // Header
        $pdf->Cell($colWidths['date'], 10, 'Date', 1, 0, 'C');
        $pdf->Cell($colWidths['earnings'], 10, 'Earnings', 1, 0, 'C');
        $pdf->Cell($colWidths['profits'], 10, 'Profits', 1, 0, 'C');
        $pdf->Cell($colWidths['description'], 10, 'Description', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 12);

        foreach ($reports as $report) {
            $pdf->Cell($colWidths['date'], 10, $report->date, 1, 0, 'C');
            $pdf->Cell($colWidths['earnings'], 10, '$' . number_format($report->earnings, 2), 1, 0, 'R');
            $pdf->Cell($colWidths['profits'], 10, '$' . number_format($report->profits, 2), 1, 0, 'R');

            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $pdf->MultiCell($colWidths['description'], 10, $report->description, 1, 'L');

            $pdf->SetXY($pdf->GetX() - $pdf->GetX() + 10, max($y + 10, $pdf->GetY()));
        }

        $savePath = '../StoreManagementApp/pdf/reports.pdf';
        $pdf->Output('F', $savePath);

        header('Location: ../pdf/reports.pdf');
        exit;
    }
}
