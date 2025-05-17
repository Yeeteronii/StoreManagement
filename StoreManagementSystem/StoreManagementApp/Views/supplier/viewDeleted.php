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
$canRestore = $data['canRestore'] ?? false;
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
    <title>Deleted Suppliers</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/suppliers.css">
</head>
<body>
<div class="main-content">
    <div class="header">
        <h2>Deleted Suppliers</h2>
    </div>
    <div class="controls">
        <form method="GET" action="<?= dirname($path); ?>/supplier/viewDeleted">
            <input type="text" name="search" placeholder="Search product..."
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?php echo dirname($path); ?>/images/search-light.png">
            </button>
        </form>
    </div>

    <table id="deletedSupplierTable">
        <tr>
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
                                    <img src="<?= $dirname ?>/images/arrow-up-light.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow-down-light.png" class="sort-icon">
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
                <td><?= htmlspecialchars($supplier->supplierName) ?></td>
                <td><?= htmlspecialchars($supplier->email) ?></td>
                <td><?= htmlspecialchars(formatPhoneNumber($supplier->phoneNum)) ?></td>
                <td>
                    <?php if ($canRestore): ?>
                        <a href=<?= dirname($path); ?>/supplier/restore/<?= $supplier->supplierId ?>">
                            <button type="button" style="padding: 5px; background-color: #a5d6a7; border-radius: 4px;">
                                Restore
                            </button>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table
</div>
<div style="position: fixed; bottom: 20px; right: 20px;">
    <a href="<?= dirname($path); ?>/supplier/list">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8e6f7; border-radius: 5px;">
            Back to Suppliers
        </button>
    </a>
</div>

</body>
</html>