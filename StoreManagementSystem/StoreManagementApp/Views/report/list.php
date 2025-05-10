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

$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;
$canViewDeleted = $data['canViewDeleted'] ?? false;
$canDownload = $data['canDownload'] ?? false;
?>

<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Report View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/reports.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2>Report Table</h2>
    </div>
    <div class="controls">
        <?php if ($canDownload): ?>
        <a href="../report/download" target="_blank">
            <button type="button" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/pdf-light.png" alt="Download" style="width: 20px; height: 20px;">
            </button>
        </a>
        <?php endif; ?>
            <?php if ($canAdd): ?>
                <a href="../report/add">
                    <button type="button" class="icon-btn">
                        <img src="<?= $dirname ?>/images/add-light.png">
                    </button>
                </a>
            <?php endif; ?>
        <form id="deleteForm" method="POST" action="../report/delete">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/delete-light.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <table id="reportTable">
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <?php
            $headers = [
                'date' => 'Date',
                'earnings' => 'Earnings',
                'profits' => 'Profits',
                'descriptions' => 'Description',
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
                <td><input type="checkbox" class="delete-checkbox" value="<?= $report->reportId ?>"></td>
                <td><?= htmlspecialchars($report->date) ?></td>
                <td>$<?= number_format($report->earnings, 2) ?></td>
                <td>$<?= number_format($report->profits, 2) ?></td>
                <td><?= htmlspecialchars($report->description) ?></td>
                <td>
                    <a href="<?= $dirname ?>/report/update/<?= $report->reportId ?>">
                        <img src="<?= $dirname ?>/images/update-light.png" alt="Edit" style="width:20px; height:20px;"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = checked);
        });

        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            const form = this;
            form.querySelectorAll('input[name="delete_ids[]"]').forEach(el => el.remove());
            document.querySelectorAll('.delete-checkbox:checked').forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_ids[]';
                input.value = cb.value;
                form.appendChild(input);
            });
        });
    </script>
</div>
<?php if ($canViewDeleted): ?>
    <div style="position: fixed; bottom: 80px; right: 20px;">
        <a href="<?= $dirname ?>/report/viewDeleted">
            <button type="button" class="icon-btn" style="padding: 10px; background-color: #f7caca; border-radius: 5px;">
                <?=VIEWDELETE?>
            </button>
        </a>
    </div>
<?php endif; ?>

</body>
</html>