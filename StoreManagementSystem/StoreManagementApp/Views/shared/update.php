<?php
if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'admin') {
    header("Location: /unauthorized");
    exit;
}
$product = $data['product'] ?? null;
?>

<?php include_once "Views/shared/sidebar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/add.css">
</head>
<body>

<div class="container">
    <h2>Update Element</h2>
    <form method="POST" action="../product/update/<?= $product->productId ?>">
        <label for="productName">Name</label>
        <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($product->productName) ?>" required>
        <div class="field-desc">The display name of your item</div>

        <label for="cost">Cost</label>
        <input type="number" step="0.01" name="cost" id="cost" value="<?= $product->cost ?>" required>
        <div class="field-desc">Field details.</div>

        <label for="priceToSell">Sell Price</label>
        <input type="number" step="0.01" name="priceToSell" id="priceToSell" value="<?= $product->PriceToSell ?>" required>
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

        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>
