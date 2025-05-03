<?php
$path = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
?>

<html>
<head>
    <title>Category - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/products.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/sidebar.php"; ?>
    <main>
        <h2 data-translate="products_title">Category</h2>
        <a href="<?php echo $basePath;?>/product/list"><input data-translate type="button" value="Back to Products"></a>
        <br>
        <br>
        <table class="table table-striped" id="category-table">
            <thead>
            <tr class="table-primary">
                <!--                <th data-translate="productId">Id</th>-->
                <th data-translate="categoryName">Name</th>
                <th data-translate="categoryTax">Category Tax</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($data as $category){
                cdebug($category->categoryId);
                ?>
                <tr>
                    <td><?= $category->categoryName;?></td>
                    <td><?= $category->categoryTax;?></td>
                    <td>
                        <a href="<?= $basePath . "/product/edit/" . $category->categoryId ?>">Edit</a>
                        <a href="<?= $basePath . "/product/delete/" . $category->categoryId ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </main>
</div>
</body>
</html>
