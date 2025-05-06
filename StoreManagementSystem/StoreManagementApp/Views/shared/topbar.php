<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<style>
@import url('https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap');
</style>
<head>
    <title>Store Management System</title>
    <link rel="stylesheet" href="../Views/styles/nav.css">
</head>
<body>

<div class="topbar">
    <div class="logo">Dépanneur du Souvenir</div>
    <div class="user-info">
        <span><?=LOGGEDIN?> <?= htmlspecialchars($role) ?></span>
        <a class="logout-button" href="../login/login"><?=LOGOUT?></a>
    </div>
</div>

<div class="main-content">
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");
        }
    </script>
