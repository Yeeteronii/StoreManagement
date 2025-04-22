<?php
$path = $_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
    <title>Suppliers - Store Management System</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/styles.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/styles/suppliers.css">

    <?php require_once dirname(__DIR__) . "/scripts.php"; ?>
</head>
<body>
<div class="container">
    <?php require_once dirname(__DIR__) . "/nav.php"; ?>
    <main>
        <h2 data-translate="suppliers_title">Suppliers</h2>
        <table class="table table-striped" id="supplier-table">
            <thead>
            <tr>
                <th data-translate="supplier_name">Name</th>
                <th data-translate="contact">Contact</th>
                <th data-translate="actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($suppliers as $supplier) { ?>
                <tr>
                    <td><?= $supplier['name']; ?></td>
                    <td><?= $supplier['contact']; ?></td>
                    <td>
                        <a href="<?= dirname($path); ?>/supplier/update/<?= $supplier['id']; ?>">Update</a>
                        <a href="<?= dirname($path); ?>/supplier/delete/<?= $supplier['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>