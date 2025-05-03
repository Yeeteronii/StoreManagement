<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Schedule - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/schedule.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/sidebar.php"; ?>
    <main>
        <h2 data-translate="schedule_title">Schedule</h2>
        <div id="schedule-grid"></div>
    </main>
</div>
</body>
</html>