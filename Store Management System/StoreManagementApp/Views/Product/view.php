<?php
$path = $_SERVER['SCRIPT_NAME'];
?>
<html>
<head>
    <title>Profile</title>
    <style>
        label{
            display: inline-block;
            width: 150px;
        }
        input[type='button']{
            width: 150px;
        }
    </style>


    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    <br><label>Product Name</label><input name="productName" value="<?php echo $data[0]->productName;?>" disabled>
    <br><label>Cost</label><input name="cost" value="<?php echo $data[0]->cost;?>$" disabled>
    <br><label>Sell Price</label><input name="priceToSell" value="<?php echo $data[0]->priceToSell;?>$" disabled>
    <br><label>Category</label><input name="categoryName" value="<?php echo $data[0]->categoryName;?>" disabled>
    <br><label>Threshold</label><input name="threshold" value="<?php echo $data[0]->threshold;?>" disabled>
    <br><label>Quantity</label><input name="quantity" value="<?php echo $data[0]->quantity;?>" disabled>


    <br><a href="<?php echo dirname($path);?>/product/list"><input type="button" value="Go to Products list"></a>
<!--    <a href="--><?php //echo dirname($path);?><!--/customer/update/--><?php //echo $data[0]->customerNumber;?><!--"><input type="button" value="Modify"></a>-->
    <br><br>

</div>
</body>
</html>