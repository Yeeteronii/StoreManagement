<?php
if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: /user/login");
    exit;
}

$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add <?= ucfirst($source) ?></title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/add.css">
</head>
<body>

<div class="header">
    Logged in as Admin
</div>

<div class="container">
    <h2>Add Elements</h2>

    <?php if ($source === 'product'): ?>
        <form method="POST" action="../product/shared/add">
            <label>Product Name
                <input type="text" name="productName" required>
                <div class="field-desc">The display name of your item</div>
            </label>

            <label>Cost
                <input type="number" step="0.01" name="cost" required>
                <div class="field-desc">How much the product cost to buy</div>
            </label>

            <label>Price to Sell
                <input type="number" step="0.01" name="priceToSell" required>
                <div class="field-desc">How much you're selling it for</div>
            </label>

            <label>Category ID
                <input type="number" name="categoryId" required>
                <div class="field-desc">Foreign key from the category table</div>
            </label>

            <label>Quantity
                <input type="number" name="quantity" required>
                <div class="field-desc">Initial quantity of stock</div>
            </label>

            <label>Threshold
                <input type="number" name="threshold" required>
                <div class="field-desc">Minimum desired inventory before warning</div>
            </label>

            <button type="submit">Add</button>
        </form>
    <?php else: ?>
        <p>Form layout for '<?= $source ?>' not yet implemented.</p>
    <?php endif; ?>
</div>

</body>
</html>
