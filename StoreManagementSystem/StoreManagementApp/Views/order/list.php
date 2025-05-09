<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$role = $_SESSION['role'];
$orders = $data['orders'] ?? [];
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
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Order View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/orders.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2><?=ORDERTABLE?></h2>
    </div>
    <div class="controls">
        <form method="GET" action=" ">
            <input type="text" name="search" placeholder="<?=SEARCH?>"
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/search.png">
            </button>
            <select name="category" onchange="this.form.submit()">
                <option value=""><?=VIEWCATEGORY?></option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <?php if ($canDelete): ?>
        <form id="deleteForm" method="POST" action="<?= $dirname ?>/order/delete">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
        <?php endif; ?>
        <form method="POST" action="<?= $dirname ?>/order/update">
            <?php if ($canUpdate): ?>
                <button type="submit" class="icon-btn" style="margin-top: 2px;">
                    <img src="<?= $dirname ?>/images/save.png" class="sort-icon">
                </button>
            <?php endif; ?>
    </div>
    <table id="orderTable">
        <tr>
            <th>
                <input type="checkbox" id="selectAll">
            </th>
            <?php
            $headers = [
                'productName' => PRODUCTNAME,
                'categoryName' => CATEGORY,
                'orderDate' => ORDERDATE,
                'quantity' => QUANTITY
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_up.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&category=<?= urlencode($category) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_down.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
        </tr>
            <?php foreach ($orders as $order): ?>
                <tr class="">
                    <td><input type="checkbox" class="delete-checkbox" value="<?= $order->orderId ?>"></td>
                    <td><?= htmlspecialchars($order->productName) ?></td>
                    <td><?= htmlspecialchars($order->categoryName) ?></td>
                    <td><?= date('d/m/Y', strtotime($order->orderDate))?></td>
                    <td>
                        <?php if ($canUpdate): ?>
                            <input type="number" name="quantity[<?= $order->orderId ?>]" value="<?= $order->quantity ?>" min="0">
                        <?php else: ?>
                            <?= $order->quantity ?>
                        <?php endif; ?>
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
</body>
</html>
