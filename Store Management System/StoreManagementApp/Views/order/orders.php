<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
    <style>
        .quantity {
        width: 50px;
    }
    </style>
<head>
    <title>Orders - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/orders.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/nav.php"; ?>
    <main>
        <h2 data-translate="orders_title">Orders</h2>
        <table class="table table-striped" id="order-table">
            <thead>
            <tr>
                <th data-translate="productName">Product Name</th>
                <th data-translate="quantity">Quantity to Order</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data as $order) { ?>
                <tr>
                    <td><?= $order->productName; ?></td>
                    <td><input class="quantity" type="number" value="<?= $order->quantity; ?>" min=0></td>
                    <td></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
