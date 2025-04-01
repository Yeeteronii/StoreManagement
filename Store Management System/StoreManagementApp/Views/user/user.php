<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Employees - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/employees.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/nav.php"; ?>
    <main>
        <h2 data-translate="employees_title">Employees</h2>
        <table class="table table-striped" id="employee-table">
            <thead>
            <tr>
                <th data-translate="employee_name">Name</th>
                <th data-translate="role">Role</th>
                <th data-translate="actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($employees as $employee) { ?>
                <tr>
                    <td><?= $employee['name']; ?></td>
                    <td><?= $employee['role']; ?></td>
                    <td>
                        <a href="<?= dirname($path); ?>/employee/update/<?= $employee['id']; ?>">Update</a>
                        <a href="<?= dirname($path); ?>/employee/delete/<?= $employee['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>