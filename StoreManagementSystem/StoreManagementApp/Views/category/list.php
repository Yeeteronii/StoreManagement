<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = ($_SERVER['SCRIPT_NAME']);
$dirname = dirname($path);
$categories = $data['categories'] ?? [];
$searchTerm = $data['search'] ?? '';
$sort = $_GET['sort'] ?? 'categoryName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';
$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;
$canOrder = $data['canOrder'] ?? false;
$canViewDeleted = $data['canViewDeleted'] ?? false;
?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Category View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/categories.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2><?=CATEGORYTABLE?></h2>
    </div>

    <div class="controls">
        <form method="GET" action="../category/list" style="display: inline;">
            <input type="text" name="search" placeholder="<?=SEARCHCATEGORY?>"
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?= $dirname ?>/images/search.png">
            </button>
        </form>

        <?php if ($canAdd): ?>
            <a href="<?= $dirname ?>/category/add">
                <button type="button" class="icon-btn">
                    <img src="<?= $dirname ?>/images/add.png">
                </button>
            </a>
        <?php endif; ?>

        <?php if ($canDelete): ?>
            <form id="deleteForm" method="POST" action="../category/delete">
                <button type="submit" class="icon-btn" style="margin-top: 2px;">
                    <img src="<?= $dirname ?>/images/delete.png" alt="Delete"
                         style="width: 20px; height: 20px;">
                </button>
            </form>
        <?php endif; ?>
    </div>

    <table id="categoryTable">
        <tr>
            <th>
                <input type="checkbox" id="selectAll">
            </th>
            <?php
            $headers = [
                'categoryName' => CATEGORYNAME,
                'categoryTax' => CATEGORYTAX
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_up.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow_down.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th><?=ACTIONS?></th>
        </tr>

        <?php foreach ($categories as $category): ?>
            <tr class="">
                <td>
                    <?php if ($canDelete): ?>
                        <input type="checkbox" class="delete-checkbox" value="<?= $category->categoryId ?>">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($category->categoryName) ?></td>
                <td>$<?= number_format($category->categoryTax, 2) ?></td>
                <td>
                    <?php if ($canUpdate): ?>
                        <a href="<?= $dirname ?>/category/update/<?= $category->categoryId ?>">
                            <img src="<?= $dirname ?>/images/update.png" alt="Edit" style="width:20px; height:20px;">
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = checked);
        });
        document.getElementById('deleteForm').addEventListener('submit', function (e) {
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
        <a href="<?= $dirname ?>/category/viewDeleted">
            <button type="button" class="icon-btn" style="padding: 10px; background-color: #f7caca; border-radius: 5px;">
            <?=VIEWDELETE?>
            </button>
        </a>
    </div>
<?php endif; ?>

<div style="position: fixed; bottom: 20px; right: 20px;">
    <a href="<?= $dirname ?>/product/list">
        <button type="button" class="icon-btn" style="padding: 10px; background-color: #c8e6f7; border-radius: 5px;">
        <?=BACKPRODUCT?>
        </button>
    </a>
</div>
</body>
</html>
