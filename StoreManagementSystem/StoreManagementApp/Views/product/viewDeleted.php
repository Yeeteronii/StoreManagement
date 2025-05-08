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
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Deleted Products</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/products.css">
</head>
<body>
<div class="main-content">
    <div class="header">
        <h2>Deleted Products</h2>
    </div>
    <table id="deletedProductTable">
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Cost</th>
            <th>Sell Price</th>
            <th>Quantity</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product->productName) ?></td>
                <td><?= htmlspecialchars($product->categoryName) ?></td>
                <td>$<?= number_format($product->cost, 2) ?></td>
                <td>$<?= number_format($product->priceToSell, 2) ?></td>
                <td><?= $product->quantity ?>/<?= $product->threshold ?></td>
                <td>
                    <a href="../product/restore/<?= $product->productId ?>">
                        <button type="button" style="padding: 5px; background-color: #a5d6a7; border-radius: 4px;">
                            Restore
                        </button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
