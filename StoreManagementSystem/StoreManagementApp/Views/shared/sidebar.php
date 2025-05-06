<!DOCTYPE html>
<html>
<head>
    <title>Store Management System</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/nav.css">
</head>
<body>
<div class="topbar">
    <div class="logo">Depanneur du Souvenir</div>
    <div class="user-info">
        <span>Logged in as <?= htmlspecialchars($role) ?></span>
        <a class="logout-button" href="../login/login">Logout</a>
    </div>
</div>

<div class="sidebar-header" onclick="toggleSidebar()">
    <img id="menuIcon" src="/StoreManagement/StoreManagementSystem/StoreManagementApp/images/menu.png" alt="Menu" class="menu-icon">
</div>
<?php if ($_SESSION['role'] === 'admin'): ?>
<div class="sidebar" id="sidebar">
    <ul class="nav-links">
<<<<<<< HEAD
        <li><a href="../product/list"><?=PRODUCT?></a></li>
        <li><a href="../schedule/view"><?=SCHEDULE?></a></li>
        <li><a href="../order/list"><?=ORDERS?></a></li>
        <li><a href="../supplier/view"><?=SUPPLIERS?></a></li>
        <li><a href="../employee/view"><?=EMPLOYEES?></a></li>
        <li><a href="../report/view"><?=REPORTS?></a></li>
        <li><a href="../setting/view"><?=SETTINGS?></a></li>
=======
        <li><a href="../product/list">Products</a></li>
        <li><a href="../shift/list">Schedule</a></li>
        <li><a href="../order/list">Orders</a></li>
        <li><a href="../supplier/view">Suppliers</a></li>
        <li><a href="../employee/view">Employees</a></li>
        <li><a href="../report/view">Reports</a></li>
        <li><a href="../setting/view">Settings</a></li>
>>>>>>> b1abf8cc81ba79a9b12b718b2c2b0f7ef63b2180
    </ul>
</div>
<?php else : ?>
<div class="sidebar" id="sidebar">
    <ul class="nav-links">
<<<<<<< HEAD
        <li><a href="../product/list"><?=PRODUCT?></a></li>
        <li><a href="../schedule/view"><?=SCHEDULE?></a></li>
        <li><a href="../setting/view"><?=SETTINGS?></a></li>
=======
        <li><a href="../product/list">Products</a></li>
        <li><a href="../shift/view">Schedule</a></li>
        <li><a href="../setting/view">Settings</a></li>
>>>>>>> b1abf8cc81ba79a9b12b718b2c2b0f7ef63b2180
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
                menuIcon.style.display = "none";
            } else {
                menuIcon.style.display = "block";
            }
        }
    </script>
</div>
</body>
</html>
