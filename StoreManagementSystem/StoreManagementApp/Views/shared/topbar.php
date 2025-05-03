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
</head>
<body>

<div class="topbar">
    <div class="logo">Depanneur du Souvenir</div>
    <div class="user-info">
        <span>Logged in as <?= htmlspecialchars($role) ?></span>
        <a class="logout-button" href="../user/login">Logout</a>
    </div>
</div>

<div class="main-content">
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");
        }
    </script>
