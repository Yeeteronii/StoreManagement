<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$role = $_SESSION['role'];
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
?>

<link rel="stylesheet" href="<?= $dirname ?>/Views/styles/nav.css">
<div class="sidebar-header" onclick="toggleSidebar()">
        <img id="menuIcon" src="<?php echo dirname($path); ?>/images/menu-light.png" alt="Menu" class="menu-icon">
    </div>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <div class="sidebar" id="sidebar">
            <ul class="nav-links">
                <li><a href="<?= dirname($path); ?>/product/list"><?=PRODUCT?></a></li>
                <li><a href="<?= dirname($path); ?>/shift/list"><?=SHIFT?></a></li>
                <li><a href="<?= dirname($path); ?>/order/list"><?=ORDERS?></a></li>
                <li><a href="<?= dirname($path); ?>/supplier/list"><?=SUPPLIERS?></a></li>
                <li><a href="<?= dirname($path); ?>/user/list"><?=EMPLOYEES?></a></li>
                <li><a href="<?= dirname($path); ?>/report/list"><?=REPORTS?></a></li>
                <li><a href="<?= dirname($path); ?>/settings/list"><?=SETTINGS?></a></li>
                <li><a href="<?=dirname($path);?>/Util/AdminGuide.pdf"><?=VIEWGUIDE?></a></li>
            </ul>
        </div>
    <?php else : ?>
        <div class="sidebar" id="sidebar">
            <ul class="nav-links">
                <li><a href="<?= dirname($path); ?>/product/list"><?=PRODUCT?></a></li>
                <li><a href="<?= dirname($path); ?>/shift/list"><?=SHIFT?></a></li>
                <li><a href="<?= dirname($path); ?>/settings/list"><?=SETTINGS?></a></li>
                <li><a href="<?=dirname($path);?>/Util/EmployeeGuide.pdf"><?=VIEWGUIDE?></a></li>
            </ul>
        </div>
    <?php endif; ?>
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
                const sidebarHeader = document.querySelector(".sidebar-header");
                sidebarHeader.onclick = toggleSidebar;
            </script>
