<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$product = $data['product'];
$category = $data['category'] ;
$source = strtolower($_GET['controller'] ?? 'unknown');
?>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Element</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/add.css">
</head>
<body>

<div class="container">
    <h2>Update Element</h2>

    <?php if ($source === 'product'): ?>
        <form method="POST" action="../shared/update/<?= $product->productId ?>">
            <label for="productName">Name</label>
            <input type="text" name="productName" id="productName" value="<?= htmlspecialchars($product->productName) ?>" required>
            <div class="field-desc">The display name of your item</div>

            <label for="cost">Cost</label>
            <input type="number" step="0.01" name="cost" id="cost" value="<?= $product->cost ?>" required>
            <div class="field-desc">Field details.</div>

            <label for="priceToSell">Sell Price</label>
            <input type="number" step="0.01" name="priceToSell" id="priceToSell" value="<?= $product->priceToSell ?>" required>
            <div class="field-desc">Field details.</div>

            <label for="categoryId">Category ID</label>
            <input type="number" name="categoryId" id="categoryId" value="<?= $product->categoryId ?>" required>
            <div class="field-desc">Field details.</div>

            <label for="threshold">Threshold</label>
            <input type="number" name="threshold" id="threshold" value="<?= $product->threshold ?>" required>
            <div class="field-desc">Field details.</div>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="<?= $product->quantity ?>" required>
            <div class="field-desc">Field details.</div>

            <button type="submit">Update Product</button>
        </form>
    <?php elseif ($_SESSION['role'] === 'admin'): ?>
        <?php if ($source === 'category'): ?>
            <form method="POST" action="../category/shared/update/<?= $category->categoryId ?>">
                <label for="categoryName">Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($category->categoryName) ?>" required>
                <div class="field-desc">The name of your category</div>

                <label for="categoryTax">Category Tax</label>
                <input type="number" step="0.01" name="categoryTax" id="categoryTax" value="<?= $category->categoryTax ?>" required>
                <div class="field-desc">Taxes for this category (in decimal).</div>

                <button type="submit">Update</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>You do not have permission to access this section.</p>
    <?php endif; ?>
</div>

</body>
</html>
