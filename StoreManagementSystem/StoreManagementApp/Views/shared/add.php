<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Element</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/add.css">
</head>
<body>

<div class="container">
    <h2>Add Element</h2>

    <?php if ($source === 'product' && $role === 'admin'): ?>
        <form method="POST" action="../product/shared/add">
            <label for="productName">Name</label>
            <input type="text" name="productName" id="productName" required>
            <div class="field-desc">The display name of your item</div>

            <label for="cost">Cost</label>
            <input type="number" step="0.01" name="cost" id="cost" required>
            <div class="field-desc">How much then item costs.</div>

            <label for="priceToSell">Sell Price</label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" required>
            <div class="field-desc">Price needed to sell the item.</div>

            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" required>
            <div class="field-desc">Category that this item belongs to .</div>

            <label for="threshold">Threshold</label>
            <input type="number" name="threshold" id="threshold" required>
            <div class="field-desc">Amount needed to be considered in stock.</div>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" required>
            <div class="field-desc">How much product is currently available.</div>

            <button type="submit">Add Product</button>
        </form>
    <?php elseif ($source === 'category' && $role === 'admin'): ?>
        <form method="POST" action="../category/shared/add">
            <label for="categoryName">Name</label>
            <input type="text" name="categoryName" id="categoryName" required>
            <div class="field-desc">The name of your category</div>

            <label for="categoryTax">Category Tax</label>
            <input type="number" step="0.01" name="categoryTax" id="categoryTax" required>
            <div class="field-desc">Taxes for this category (in decimal)</div>

            <button type="submit">Add Category</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
