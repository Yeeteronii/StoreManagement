<?php
if (!isset($_SESSION['token'])) {
    header("Location: /login/login");
    exit;
}
$username = $_SESSION['username'];
$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap');
</style>

<link rel="stylesheet" href="<?= $dirname ?>/Views/styles/nav.css">
<div class="topbar">
        <div class="logo">Dépanneur du Souvenir</div>
        <div class="user-info">
            <span><?=LOGGEDIN?> <?= htmlspecialchars($username) ?></span>
            <!-- <a class="logout-button" href="../login/login"><?=LOGOUT?></a> -->
            <!-- <div style="font-size: 10px; color: red">Change Translation</div> -->
            <div class="language-switch" style="margin-left: 10px;">
    <form method="POST" action="">
        <select name="lang" onchange="this.form.submit()">
            <option value="en" <?= $_SESSION['lang'] === 'en' ? 'selected' : '' ?>>English</option>
            <option value="fr" <?= $_SESSION['lang'] === 'fr' ? 'selected' : '' ?>>Français</option>
        </select>
    </form>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");
        }
    </script>
</div>
    <div class="darktheme-buttons">
        <a href="" class="darktheme-button">Dark</a>
        <a href="" class="lighttheme-button">Light</a>
        <script>
            const darkButton = document.querySelector('.darktheme-button');
            const lightButton = document.querySelector('.lighttheme-button');

            darkButton.addEventListener('click', function(event) {
                event.preventDefault();
                document.body.classList.add('darktheme');
            });

            lightButton.addEventListener('click', function(event) {
                event.preventDefault();
                document.body.classList.remove('darktheme');
            });
        </script>
    </div>

        </div>
    </div>

    