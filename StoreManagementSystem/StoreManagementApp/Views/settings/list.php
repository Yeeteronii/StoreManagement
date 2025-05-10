<?php
$path = $_SERVER['SCRIPT_NAME'];
?>




<!DOCTYPE html>
<html>
<head>
    <title>Settings - Store Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/shared.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/darktheme.css">
</head>
<body>
<?php include_once "Views/shared/topbar.php"; ?>
<?php include_once "Views/shared/sidebar.php"; ?>

<div class="container">
    <?php
    if (isset($_SESSION['notification'])) {
        echo "<div class='notification'>" . $_SESSION['notification'] . "</div>";
        unset($_SESSION['notification']);
    }
    ?>

    <br><br>
    <a style="float: right" class="logout-button-large" href="../login/login"><?=LOGOUT?></a>
    <h2 data-translate="settings_title">Settings</h2>
    
    <form action="../settings/update/<?= $user->id ?>" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= $user->username ?>" required>

        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="" >
        <div class="field-desc">Enter new password if you wish to change it. Otherwise leave blank.</div>

        <button type="submit">Update Credentials</button>
    </form>

    

    <script>
        jQuery(document).ready(function($) {
            $('body').on('click', function() {
                // Hide the notification after 3 seconds

            });
        });
    </script>
    



    



</div>
</body>
</html>