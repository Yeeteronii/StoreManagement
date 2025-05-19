<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$users = $data['users'] ?? [];


$searchTerm = $data['search'] ?? '';
$sort = $_GET['sort'] ?? 'supplierName';
$dir = $_GET['dir'] ?? 'asc';
$nextDir = ($dir === 'asc') ? 'desc' : 'asc';

$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>User View</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/users.css">
    <script>
        function toggleCheckboxes(source) {
            document.querySelectorAll('input[name="delete_ids[]"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</head>

<body>
<div class="main-content">
    <div class="header">
        <h2><?=USERTABLE?></h2>
    </div>
    <div class="controls">
        <form method="GET" action="<?= dirname($path); ?>/user/list">
            <input type="text" name="search" placeholder="<?=SEARCHUSER?>"
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="icon-btn">
                <img src="<?= $dirname ?>/images/search-light.png">
            </button>
            <?php if ($canAdd): ?>
                <a href="<?= dirname($path); ?>/user/add">
                    <button type="button" class="icon-btn">
                        <img src="<?= $dirname ?>/images/add-light.png">
                    </button>
                </a>
            <?php endif; ?>
        </form>
        <form id="deleteForm" method="POST" action="<?= dirname($path); ?>/user/delete">
            <button type="submit" class="icon-btn" style="margin-top: 2px;">
                <img src="<?= $dirname ?>/images/delete-light.png" alt="Delete" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <table id="supplierTable">
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <?php
            $headers = [
                'username' => USERNAME,
                'password' => PASSWORD,
                'role' => ROLE,
            ];
            foreach ($headers as $field => $label): ?>
                <th>
                    <div class="sortable-header">
                        <?= $label ?>
                        <div class="sort-arrows">
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=asc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow-up-light.png" class="sort-icon">
                                </button>
                            </a>
                            <a href="?search=<?= urlencode($searchTerm) ?>&sort=<?= $field ?>&dir=desc">
                                <button type="button" class="sort-btn">
                                    <img src="<?= $dirname ?>/images/arrow-down-light.png" class="sort-icon">
                                </button>
                            </a>
                        </div>
                    </div>
                </th>
            <?php endforeach; ?>
            <th><?=ACTIONS?></th>
        </tr>
        <?php foreach ($users as $user): ?>

            <tr>
                <td><input type="checkbox" class="delete-checkbox" value="<?= $user->id ?>"></td>
                <td><?= htmlspecialchars($user->username) ?></td>
                <td><?= str_repeat('*', strlen($user->password)) ?></td>
                <td><?= htmlspecialchars($user->role)?></td>
                <td>
                    <a href="<?= $dirname ?>/user/update/<?= $user->id ?>">
                        <img src="<?= $dirname ?>/images/update-light.png" alt="Edit" style="width:20px; height:20px;"></a>
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