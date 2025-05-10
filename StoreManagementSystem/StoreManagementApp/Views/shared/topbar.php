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
<link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/darktheme.css">
<div class="topbar">
    <div class="logo" style="font-family: 'Charm', cursive; font-size: 28px; color: darkred;">
        Dépanneur du Souvenir
    </div>
    <div class="user-info" style="display: flex; align-items: center; gap: 10px;">
        <span><strong><?= LOGGEDIN ?> <?= htmlspecialchars($username) ?></strong></span>

        <div class="language-switch">
            <form method="POST" action="">
                <select name="lang" onchange="this.form.submit()">
                    <option value="en" <?= $_SESSION['lang'] === 'en' ? 'selected' : '' ?>>English</option>
                    <option value="fr" <?= $_SESSION['lang'] === 'fr' ? 'selected' : '' ?>>Français</option>
                </select>
            </form>
        </div>

        <div class="theme-toggle">
            <img src="<?= $dirname ?>/images/darkmode.png" id="darkIcon" alt="Enable Dark Mode" title="Dark Mode" style="width: 24px; height: 24px; cursor: pointer;">
            <img src="<?= $dirname ?>/images/lightmode.png" id="lightIcon" alt="Enable Light Mode" title="Light Mode" style="width: 24px; height: 24px; cursor: pointer; display: none;">
        </div>
    </div>
</div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");
        }
    </script>
<script>
    function updateThemeImages(isDarkTheme) {
        document.querySelectorAll('img').forEach(img => {
            if (img.id === 'darkIcon' || img.id === 'lightIcon') return;
            const src = img.src;
            if (isDarkTheme) {
                img.src = src.replace('-light.png', '-dark.png');
            } else {
                img.src = src.replace('-dark.png', '-light.png');
            }
        });
    }

    const darkIcon = document.getElementById('darkIcon');
    const lightIcon = document.getElementById('lightIcon');

    window.addEventListener('DOMContentLoaded', () => {
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.body.classList.add('darktheme');
            darkIcon.style.display = 'none';
            lightIcon.style.display = 'inline';
            updateThemeImages(true);
        } else {
            document.body.classList.remove('darktheme');
            darkIcon.style.display = 'inline';
            lightIcon.style.display = 'none';
            updateThemeImages(false);
        }
    });

    darkIcon.addEventListener('click', () => {
        document.body.classList.add('darktheme');
        darkIcon.style.display = 'none';
        lightIcon.style.display = 'inline';
        updateThemeImages(true);
        localStorage.setItem('theme', 'dark');
    });

    lightIcon.addEventListener('click', () => {
        document.body.classList.remove('darktheme');
        darkIcon.style.display = 'inline';
        lightIcon.style.display = 'none';
        updateThemeImages(false);
        localStorage.setItem('theme', 'light');
    });
</script>


    