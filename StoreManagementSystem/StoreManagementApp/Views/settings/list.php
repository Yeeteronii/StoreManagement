<?php
$path = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/shared.css">
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/darktheme.css">
</head>
<body>
<?php include_once "Views/shared/topbar.php"; ?>
<?php include_once "Views/shared/sidebar.php"; ?>

<div class="container">
    <?php
    if (isset($_SESSION['notification']) && $_SESSION['notificationStatus'] == "success") {
        echo "<div class='notification-success'>" . $_SESSION['notification'] . "</div>";
        unset($_SESSION['notification']);
    } elseif (isset($_SESSION['notification']) && $_SESSION['notificationStatus'] == "failed") {
        echo "<div class='notification-failed'>" . $_SESSION['notification'] . "</div>";
        unset($_SESSION['notification']);
    }
    ?>

    <br><br>
    <a style="float: right" class="logout-button-large" href="<?= dirname($path); ?>/login/login"><?=LOGOUT?></a>
    <h2 data-translate="settings_title"><?=SETTINGS?></h2>
    
    <form action="<?= dirname($path); ?>/settings/update/<?= $user->id ?>" method="POST">
        <label for="username"><?=USERNAME?></label>
        <input type="text" name="username" id="username" value="<?= $user->username ?>" required>

        <label for="password"><?=PASSWORD?></label>
        <input type="text" name="password" id="password" value="" >
        <div class="field-desc"><?=UPDATEPASSWORDTOLTIP?></div>

        <button type="submit"><?=UPDATECRED?></button>
    </form>
    <script>
        jQuery(document).ready(function($) {
            $('body').on('click', function() {
                $('.notification').fadeOut(300);
            });

            setTimeout(function() {
                $('.notification').fadeOut(300);
            }, 3000);
        });
    </script>
</div>
</body>
</html>