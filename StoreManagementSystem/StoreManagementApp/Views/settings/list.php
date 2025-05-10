<?php
$path = $_SERVER['SCRIPT_NAME'];
?>




<!DOCTYPE html>
<html>
<head>
    <title>Settings - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/shared.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/nav.css">
</head>
<body>
<?php include_once "Views/shared/topbar2.php"; ?>
<?php include_once "Views/shared/sidebar2.php"; ?>

<div class="container">
    <h2 data-translate="settings_title">Settings</h2>
    <label data-translate="language_label">Language:</label>
    <select id="language-select">
        <option value="en">English</option>
        <option value="fr">French</option>
    </select>
</div>
</body>
</html>