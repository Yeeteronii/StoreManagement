<?php
$basePath = dirname($_SERVER['SCRIPT_NAME']);
?>
<tr>
    <td><?= htmlspecialchars($product->productName); ?></td>
    <td><?= htmlspecialchars($product->categoryName); ?></td>
    <td><?= htmlspecialchars($product->quantity); ?></td>
    <td>
        <a href="<?= htmlspecialchars($basePath . '/product/view/' . $product->productId); ?>"><img class="icons" src="<?= htmlspecialchars($basePath . '/images/view.png'); ?>"></a>
        <a href="<?= htmlspecialchars($basePath . '/product/edit/' . $product->productId); ?>"><img class="icons" src="<?= htmlspecialchars($basePath . '/images/edit.png'); ?>"></a>
        <a href="<?= htmlspecialchars($basePath . '/product/delete/' . $product->productId); ?>"><img class="icons" src="<?= htmlspecialchars($basePath . '/images/delete.png'); ?>"></a>
    </td>
</tr>