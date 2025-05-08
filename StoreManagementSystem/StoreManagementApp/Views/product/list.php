<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$products = $data['products'] ?? [];
$searchTerm = $data['search'] ?? '';
$category = $data['category'] ?? '';
$categories = $data['categories'] ?? [];
$sort = $_GET['sort'] ?? 'productName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';
$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;
$canOrder = $data['canOrder'] ?? false;
$canCategory = $data['canCategory'] ?? false;
$canViewDeleted = $data['canViewDeleted'] ?? false;
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Product View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/products.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2>Products Table</h2>
    </div>
    <div class="controls">
        <form method="GET" action="../product/list">
            <input type="text" name="search" placeholder="Search product..."
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?php echo dirname($path); ?>/images/search.png">
            </button>
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ($canAdd): ?>
                <a href="../product/add">
                    <button type="button" class="icon-btn">
                        <img src="<?php echo dirname($path); ?>/images/add.png">
                    </button>
                </a>
            <?php endif; ?>
        </form>
        <form id="deleteForm" method="POST" action="../product/delete">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?php echo dirname($path); ?>/images/delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <table id="productTable">
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <?php
            $headers = [
                'productName' => 'Product Name',
                'categoryName' => 'Category',
                'cost' => 'Cost',
                'priceToSell' => 'Sell Price',
                'quantity' => 'Quantity'
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?php echo dirname($path); ?>/images/sort_arrow_up.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?php echo dirname($path); ?>/images/sort_arrow_down.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <?php
            $rowClass = '';
            if ($product->quantity == 0) $rowClass = 'row-red';
            elseif ($product->quantity < $product->threshold) $rowClass = 'row-yellow';
            ?>
            <tr class="<?= $rowClass ?>">
                <td><input type="checkbox" class="delete-checkbox" value="<?= $product->productId ?>"></td>
                <td><?= htmlspecialchars($product->productName) ?></td>
                <td><?= htmlspecialchars($product->categoryName) ?></td>
                <td>$<?= number_format($product->cost, 2) ?></td>
                <td>$<?= number_format($product->priceToSell, 2) ?></td>
                <td><?= $product->quantity ?>/<?= $product->threshold ?></td>
                <td>
                    <a href="../product/update/<?= $product->productId ?>">
                        <img src="<?php echo dirname($path); ?>/images/update.png" alt="Edit" style="width:20px; height:20px;"></a>

                    <a href="../product/addToOrder/<?= $product->productId ?>">
                        <?php if (!empty($product->isInOrder)): ?>
                            <img src="<?php echo dirname($path); ?>/images/ordered.png" alt="Already in Order" title="Already in Order" style="width:20px; height:20px;">
                        <?php else: ?>
                            <img src="<?php echo dirname($path); ?>/images/order.png" alt="Add to Order" title="Add to Order" style="width:20px; height:20px;">
                        <?php endif; ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checked = this.checked;
            document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = checked);
        });

        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            const form = this;
            form.querySelectorAll('input[name="delete_ids[]"]').forEach(el => el.remove());
            document.querySelectorAll('.delete-checkbox:checked').forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_ids[]';
                input.value = cb.value;
                form.appendChild(input);
            });
        });
    </script>
</div>
<?php if ($canViewDeleted): ?>
<div style="position: fixed; bottom: 80px; right: 20px;">
    <a href="../product/viewDeleted">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #f7caca; border-radius: 5px;">
            View Deleted
        </button>
    </a>
</div>
<?php endif; ?>

<?php if ($canCategory): ?>
    <div style="position: fixed; bottom: 20px; right: 20px;">
        <a href="../category/list">
            <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8b8e6; border-radius: 5px;">
                View Categories
            </button>
        </a>
    </div>
<?php endif; ?>

</body>
</html>