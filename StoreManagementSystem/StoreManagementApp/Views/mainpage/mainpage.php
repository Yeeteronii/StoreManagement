<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Main Menu - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/mainpage.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/sidebar.php"; ?>
    <main>
        <h2 data-translate="welcome_title">Welcome</h2>
        <p data-translate="welcome_message">Select a page from the sidebar.</p>
        <div id="admin-section" style="display: none;">
            <button id="manage-users" data-translate="manage_users">Manage Users</button>
        </div>
    </main>
</div>
</body>
</html>