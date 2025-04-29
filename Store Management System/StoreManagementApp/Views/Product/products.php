<?php
$path = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
?>


<html>
<style>
    
    .quantity{
        width: 50px;
    }
    .icons{
        width: 24px;
        height: 24px;
    }
</style>
<head>
    <title>Products - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/products.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
    <!-- Search bar script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#search-input').focus();
            $('#search-input').on('input', function(){
                var searchText = $(this).val();
                if (searchText.trim() !== "") {
                    $.ajax({
                        url: '<?php echo $basePath; ?>/product/list', // Replace with your actual search URL
                        type: 'POST',
                        data: {searchText: searchText},
                        success: function(data){
                            $('#product-table tbody').html(data);
                        }
                    });
                } else {
                    // Reload the page to display the full list of products
                    location.reload();
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <?php require_once dirname(__DIR__) . "/nav.php"; ?>
        <main>
            <h2 data-translate="products_title">Products</h2>

            <input type="text" id="search-input" placeholder="Search products...">
            <button id="add-product-btn" data-translate="add_product">Add Product</button>
            <a href="<?php echo $basePath; ?>/category/list"><input data-translate type="button" value="Categories"></a>
            <a href="<?php echo $basePath; ?>/category/deleteProducts"><input data-translate type="button" value="Delete Products"></a> <!-- Deleted multiple products -->
            <br>
            <br>
            <form method="POST" action=""></form>
            <table class="table table-striped" id="product-table">
                <thead>
                    <tr class="table-primary">
                        <!--                <th data-translate="productId">Id</th>-->
                        <th data-translate="selectBox"></th>
                        <th data-translate="product_name">Name</th>
                        <th data-translate="category">Category</th>
                        <th data-translate="quantity">Quantity</th>
                        <th data-translate="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($data as $product) {
                        // cdebug($product->productId);
                    ?>
                        <tr>
                            <!--<td><?= $product->productId; ?></td>-->
                            <td><input type="checkbox" name="productIds[]" class="select-product" value="<?= $product->productId; ?>"></td>
                            <td><?= $product->productName; ?></td>
                            <td><?= $product->categoryName; ?></td>
                            <td><input class="quantity" type="number" value="<?=$product->quantity;?>" min=0></td>
                            <td>
                                <!--<a href="--><?php //= dirname($path) . "/product/view/" . $product->productId;  ?><!--">View</a>-->

                                <a href="<?= $basePath . "/product/view/" . $product->productId; ?>"><img class="icons" src="<?= $basePath . "/images/view.png" ?>"></a>
                                <a href="<?= $basePath . "/product/edit/" . $product->productId; ?>"><img class="icons" src="<?= $basePath . "/images/edit.png" ?>"></a>
                                <a href="<?= $basePath . "/product/delete/" . $product->productId ?>"><img class="icons" src="<?= $basePath . "/images/delete.png" ?>"></a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

        </main>
    </div>
</body>

</html>