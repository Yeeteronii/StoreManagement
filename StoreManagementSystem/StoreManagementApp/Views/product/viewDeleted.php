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
    <title><?= DELETEDPRODUCTS?></title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/products.css">
</head>
<body>
<div class="main-content">
    <div class="header">
        <h2><?= DELETEDPRODUCTS?></h2>
    </div>
    <div class="controls">
        <form method="GET" action="<?= dirname($path); ?>/product/viewDeleted">
            <input type="text" name="search" placeholder="Search product..."
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?php echo dirname($path); ?>/images/search-light.png">
            </button>
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat->categoryName) ?>" <?= $category === $cat->categoryName ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat->categoryName) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <table id="deletedProductTable">
        <tr>
            <?php
            $headers = [
                'productName' => PRODUCTNAME,
                'categoryName' => CATEGORY,
                'cost' => COST,
                'priceToSell' => SELLPRICE,
                'taxPrice' => TAXPRICE,
                'quantity' => QUANTITY
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?php echo dirname($path); ?>/images/arrow-up-light.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?php echo dirname($path); ?>/images/arrow-down-light.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product->productName) ?></td>
                <td><?= htmlspecialchars($product->categoryName) ?></td>
                <td>$<?= number_format($product->cost, 2) ?></td>
                <td>$<?= number_format($product->priceToSell, 2) ?></td>
                <td>$<?= number_format($product->taxPrice, 2) ?></td>
                <td><?= $product->quantity ?>/<?= $product->threshold ?></td>
                <td>
                    <?php if ($canRestore): ?>
                    <a href="<?= dirname($path); ?>/product/restore/<?= $product->productId ?>">
                        <button type="button" style="padding: 5px; background-color: #a5d6a7; border-radius: 4px;">
                            Restore
                        </button>
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div style="position: fixed; bottom: 20px; right: 20px;">
    <a href="<?= dirname($path); ?>/product/list">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8e6f7; border-radius: 5px;">
            Back to Products
        </button>
    </a>
</div>

</body>
</html>
