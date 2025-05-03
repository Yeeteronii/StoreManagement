<?php
if (!isset($_SESSION['token'])) {
    header("Location: /user/login");
    exit;
}
$role = $_SESSION['role'] ?? 'employee';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Management System</title>
    <link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/nav.css">
<div class="sidebar-header" onclick="toggleSidebar()">☰</div>

<div class="sidebar" id="sidebar">
    <ul class="nav-links">
        <li><a href="../main">🏠 Main</a></li>
        <li><a href="../product/list">📦 Products</a></li>
        <li><a href="../schedule/view">🗓️ Schedule</a></li>
        <li><a href="../order/view">🧾 Orders</a></li>
        <li><a href="../supplier/view">🏭 Suppliers</a></li>
        <li><a href="../employee/view">👥 Employees</a></li>
        <li><a href="../report/view">📊 Reports</a></li>
        <li><a href="../setting/view">⚙️ Settings</a></li>
    </ul>
</div>


<div class="main-content">
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");
        }
    </script>
