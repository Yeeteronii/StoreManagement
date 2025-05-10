<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$products = $data['products'] ?? [];
$searchTerm = $data['search'] ?? '';
$category = $data['category'] ?? '';
$categories = $data['categories'] ?? [];
$sort = $_GET['sort'] ?? 'productName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';
$canRestore = $data['canRestore'] ?? false;
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?=DELETEDCATEGORY?></title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/categories.css">
</head>
<body>
<div class="main-content">
    <div class="header">
        <h2><?=DELETEDPRODUCTS?></h2>
    </div>
    <table id="categoryTable">
        <tr>
            <?php
            $headers = [
                'categoryName' => CATEGORYNAME,
                'categoryTax' => CATEGORYTAX
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

        <?php foreach ($categories as $category): ?>
            <tr class="">
                <td><?= htmlspecialchars($category->categoryName) ?></td>
                <td>$<?= number_format($category->categoryTax, 2) ?></td>
                <td>
                    <?php if ($canRestore): ?>
                    <a href="<?= $dirname ?>/category/restore/<?= $category->categoryId ?>">
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
    <a href="<?= $dirname ?>/category/list">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8e6f7; border-radius: 5px;">
            <?=BACKTOCATEGORIES?>
        </button>
    </a>
</div>

</body>
</html>
