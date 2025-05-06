<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$role = $_SESSION['role'];
$categories = $data['categories'] ?? [];
$sort = $_GET['sort'] ?? 'categoryName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';
?>
<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Category View</title>
    <link rel="stylesheet" href="../Views/styles/categories.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2>Category Table</h2>
    </div>
    <div class="controls">
        <form method="GET" action="../category/list">
                <a href="../category/add">
                    <button type="button" class="icon-btn">
                        <img src="../images/add.png">
                    </button>
                </a>
        </form>
        <form id="deleteForm" method="POST" action="../category/deleteMultiple">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="../images/delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <table id="categoryTable">
        <tr>
            <th>
                <input type="checkbox" id="selectAll">
            </th>
            <?php
            $headers = [
                'categoryName' => 'Category Name',
                'categoryTax' => 'Category Tax'
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?action=list&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="../images/sort_arrow_up.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?action=list&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="../images/sort_arrow_down.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th>Actions</th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr class="">
                <td><input type="checkbox" class="delete-checkbox" value="<?= $category->categoryId ?>"></td>
                <td><?= htmlspecialchars($category->categoryName) ?></td>
                <td>$<?= number_format($category->categoryTax, 2) ?></td>
                <td>
                    <a href="../category/update/<?= $category->categoryId ?>">
                        <img src="../images/edit.png" alt="Edit" style="width:20px; height:20px;">
                    </a>
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
