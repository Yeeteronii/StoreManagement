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
        <li><a href="../product/list">Products</a></li>
        <li><a href="../schedule/view">Schedule</a></li>
        <li><a href="../order/list">Orders</a></li>
        <li><a href="../supplier/view">Suppliers</a></li>
        <li><a href="../employee/view">Employees</a></li>
        <li><a href="../report/view">Reports</a></li>
        <li><a href="../setting/view">Settings</a></li>
    </ul>
</div>
<?php else : ?>
<div class="sidebar" id="sidebar">
    <ul class="nav-links">
        <li><a href="../product/list">Products</a></li>
        <li><a href="../schedule/view">Schedule</a></li>
        <li><a href="../setting/view">Settings</a></li>
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
