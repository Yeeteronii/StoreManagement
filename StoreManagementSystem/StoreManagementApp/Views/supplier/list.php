<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$suppliers = $data['suppliers'] ?? [];


$searchTerm = $data['search'] ?? '';
$sort = $_GET['sort'] ?? 'supplierName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';

$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;
$canViewDeleted = $data['canViewDeleted'] ?? false;
?>
<?php
function formatPhoneNumber($number) {
    $digits = preg_replace('/\D/', '', $number);

    if (strlen($digits) === 10) {
        return substr($digits, 0, 3) . '-' .
            substr($digits, 3, 3) . '-' .
            substr($digits, 6);
    }
    return $number;
}
?>


<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Supplier View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/suppliers.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2>Supplier Table</h2>
    </div>
    <div class="controls">
        <form method="GET" action="../supplier/list">
            <input type="text" name="search" placeholder="<?=SEARCH?>"
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?= $dirname ?>/images/search.png">
            </button>
            <?php if ($canAdd): ?>
                <a href="../supplier/add">
                    <button type="button" class="icon-btn">
                        <img src="<?= $dirname ?>/images/add.png">
                    </button>
                </a>
            <?php endif; ?>
        </form>
        <form id="deleteForm" method="POST" action="../supplier/delete">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <table id="supplierTable">
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <?php
            $headers = [
                'supplierName' => "Supplier Name",
                'email' => "E-Mail",
                'phoneNum' => "Contact Number",
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_up.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_down.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th><?=ACTIONS?></th>
        </tr>
        <?php foreach ($suppliers as $supplier): ?>

            <tr>
                <td><input type="checkbox" class="delete-checkbox" value="<?= $supplier->supplierId ?>"></td>
                <td><?= htmlspecialchars($supplier->supplierName) ?></td>
                <td><?= htmlspecialchars($supplier->email) ?></td>
                <td><?= htmlspecialchars(formatPhoneNumber($supplier->phoneNum)) ?></td>
                <td>
                    <a href="<?= $dirname ?>/supplier/update/<?= $supplier->supplierId ?>">
                        <img src="<?= $dirname ?>/images/update.png" alt="Edit" style="width:20px; height:20px;"></a>
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
        <a href="<?= $dirname ?>/supplier/viewDeleted">
            <button type="button" class="icon-btn" style="padding: 10px; background-color: #f7caca; border-radius: 5px;">
                <?=VIEWDELETE?>
            </button>
        </a>
    </div>
<?php endif; ?>

</body>
</html>