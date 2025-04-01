<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Products - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/products.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/nav.php"; ?>
    <main>
        <h2 data-translate="products_title">Products</h2>
        <button id="add-product-btn" data-translate="add_product">Add Product</button>
        <table class="table table-striped" id="product-table">
            <thead>
            <tr>
                <th data-translate="product_name">Name</th>
                <th data-translate="category">Category</th>
                <th data-translate="quantity">Quantity</th>
                <th data-translate="actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($products as $product) { ?>
                <tr>
                    <td><?= $product['name']; ?></td>
                    <td><?= $product['category']; ?></td>
                    <td><?= $product['quantity']; ?></td>
                    <td>
                        <a href="<?= dirname($path) . "/product/view/" . $product['id']; ?>">View</a>
                        <a href="<?= dirname($path) . "/product/edit/" . $product['id']; ?>">Edit</a>
                        <a href="<?= dirname($path) . "/product/delete/" . $product['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
```

