<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Settings - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/settings.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/sidebar.php"; ?>
    <main>
        <h2 data-translate="settings_title">Settings</h2>
        <label data-translate="language_label">Language:</label>
        <select id="language-select">
            <option value="en">English</option>
            <option value="fr">French</option>
        </select>
    </main>
</div>
</body>
</html>