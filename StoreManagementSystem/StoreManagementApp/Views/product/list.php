<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$role = $_SESSION['role'];
$products = $data['products'] ?? [];
$searchTerm = $data['search'] ?? '';
?>
<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Product View</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/products.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2>Products Table</h2>
    </div>

    <form method="GET" action="../product/list">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="list">
        <div class="controls">
            <input type="text" name="search" placeholder="Search product..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit">Search</button>
        </div>
    </form>

    <form method="GET" action="../product/list">
        <div class="controls">
            <select name="category">
                <option value="">Category</option>
            </select>
            <select name="field">
                <option value="">Field</option>
            </select>
            <?php if ($role === 'admin'): ?>
                <a href="../product/add"><button type="button">Add</button></a>
            <?php endif; ?>
        </div>
    </form>

    <form method="POST" action="../product/deleteMultiple">
        <table id="productTable">
            <tr>
                <?php if ($role === 'admin'): ?>
                    <th><input type="checkbox" onclick="toggleCheckboxes(this)"></th>
                <?php endif; ?>
                <th>Product Name</th>
                <th>Category</th>
                <th>Cost</th>
                <th>Sell Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($products as $product): ?>
                <?php
                $rowClass = '';
                if ($product->quantity == 0) $rowClass = 'row-red';
                elseif ($product->quantity < $product->threshold) $rowClass = 'row-yellow';
                ?>
                <tr class="<?= $rowClass ?>">
                    <?php if ($role === 'admin'): ?>
                        <td><input type="checkbox" name="delete_ids[]" value="<?= $product->productId ?>"></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($product->productName) ?></td>
                    <td><?= htmlspecialchars($product->categoryName) ?></td>
                    <td>$<?= number_format($product->cost, 2) ?></td>
                    <td>$<?= number_format($product->priceToSell, 2) ?></td>
                    <td><?= $product->quantity ?>/<?= $product->threshold ?></td>
                    <td>
                        <a href="../product/update/<?= $product->productId ?>"><button type="button">✏️</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php if ($role === 'admin'): ?>
            <button type="submit">🛒 Delete Selected</button>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
