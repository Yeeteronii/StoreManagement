<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$role = $_SESSION['role'];
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Management System</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/nav.css">
</head>
<body>
    <div class="sidebar-header" onclick="toggleSidebar()">
        <img id="menuIcon" src="<?php echo dirname($path); ?>/images/menu.png" alt="Menu" class="menu-icon">
    </div>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <div class="sidebar" id="sidebar">
            <ul class="nav-links">
                <li><a href="../product/list"><?=PRODUCT?></a></li>
                <li><a href="../shift/list"><?=SCHEDULE?></a></li>
                <li><a href="../order/list"><?=ORDERS?></a></li>
                <li><a href="../supplier/view"><?=SUPPLIERS?></a></li>
                <li><a href="../employee/view"><?=EMPLOYEES?></a></li>
                <li><a href="../report/view"><?=REPORTS?></a></li>
                <li><a href="../setting/view"><?=SETTINGS?></a></li>
            </ul>
        </div>
    <?php else : ?>
        <div class="sidebar" id="sidebar">
            <ul class="nav-links">
                <li><a href="../product/list"><?=PRODUCT?></a></li>
                <li><a href="../shift/list"><?=SCHEDULE?></a></li>
                <li><a href="../setting/view"><?=SETTINGS?></a></li>
            </ul>
        </div>
    <?php endif; ?>
        <div class="main-content">
            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById("sidebar");
                    const menuIcon = document.getElementById("menuIcon");
                    sidebar.classList.toggle("open");

                    if (sidebar.classList.contains("open")) {
                        menuIcon.style.display = "inline-block";
                    } else {
                        menuIcon.style.display = "block";
                    }
                }
            </script>
        </div>
    </body>
</html>
