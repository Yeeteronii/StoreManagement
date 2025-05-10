<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$reports = $data['report'] ?? [];

$sort = $_GET['sort'] ?? 'date';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';
$canRestore = $data['canRestore'] ?? false;
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Deleted Reports</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/reports.css">
</head>
<body>
<div class="main-content">
    <div class="header">
        <h2><?=DELETEDREPORTS?></h2>
    </div>

    <table id="deletedReportTable">
        <tr>
            <?php
            $headers = [
                'date' => DATE,
                'earnings' => EARNINGS,
                'profits' => PROFITS,
                'descriptions' => DESCRIPTION,
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow-up-light.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow-down-light.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?= htmlspecialchars($report->date) ?></td>
                <td>$<?= number_format($report->earnings, 2) ?></td>
                <td>$<?= number_format($report->profits, 2) ?></td>
                <td><?= htmlspecialchars($report->description) ?></td>
                <td>
                    <?php if ($canRestore): ?>
                    <a href="../report/restore/<?= $report->reportId ?>">
                        <button type="button" style="padding: 5px; background-color: #a5d6a7; border-radius: 4px;">
                            <?=RESTORE?>
                        </button>
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div style="position: fixed; bottom: 20px; right: 20px;">
    <a href="../report/list">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8e6f7; border-radius: 5px;">
            <?=BACKTOREPORTS?>
        </button>
    </a>
</div>

</body>
</html>
