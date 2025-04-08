<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/login.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="login-container">
    <img src="<?= dirname($path); ?>/images/defaultguy.jpg" alt="User Icon" class="user-icon">
    <h2 data-translate="login_title">User Login</h2>
    <form id="loginForm" method="POST" action="">
        <label data-translate="username_label" for="username">Username:</label>
        <input type="text" id="username" required>
        <label data-translate="password_label" for="password">Password:</label>
        <input type="password" id="password" required>
        <button type="submit" data-translate="login_button">Login</button>
        <p id="error-message" class="error-message"></p>
    </form>
</div>
</body>
</html>