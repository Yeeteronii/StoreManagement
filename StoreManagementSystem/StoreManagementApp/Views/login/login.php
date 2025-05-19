<?php $path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path); ?>
<!DOCTYPE html>
<html lang="en">


<style>
    @import url('https://fonts.googleapis.com/css2?family=Charm:wght@400;700&display=swap');
</style>


<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= dirname($path); ?>/Views/styles/darktheme.css">
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/login.css">
</head>

<body>
    <header>
        <div class="logo" style="font-family: 'Charm', cursive; font-size: 28px; color: darkred;">
            Dépanneur du Souvenir
        </div>

        <div class="theme-toggle">
            <img src="<?= $dirname ?>/images/darkmode.png" id="darkIcon" alt="Enable Dark Mode" title="Dark Mode" style="width: 24px; height: 24px; cursor: pointer;">
            <img src="<?= $dirname ?>/images/lightmode.png" id="lightIcon" alt="Enable Light Mode" title="Light Mode" style="width: 24px; height: 24px; cursor: pointer; display: none;">
        </div>
    </header>

    <div class="login-container">
        <img src="<?= $dirname ?>/images/defaultguy.jpg" alt="User Icon" class="user-icon">

        <h2 class="login-text"><?=LOGIN?></h2>
        <?php if (!empty($data['error'])): ?>
            <div style="background-color: #fdd; color: darkred; padding: 10px; border: 1px solid darkred; margin-bottom: 10px;">
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?= dirname($path); ?>/login/login">
            <input type="text" name="username" placeholder="<?=USERNAME?>" required>
            <input type="password" name="password" placeholder="<?=PASSWORD?>" required>
            <button type="submit" class="login-button"><?=LOGIN?></button>
        </form>
        <br><br>
        <button> <a href="<?= $dirname ?>/Util/<?=LOGINGUIDE?>.pdf">
            <?= VIEWGUIDE ?>
            </a>
        </button>

    </div>

    <div class="language-switch">
        <form method="POST" action="">
            <select name="lang" onchange="this.form.submit()">
                <option value="en" <?= $_SESSION['lang'] === 'en' ? 'selected' : '' ?>>English</option>
                <option value="fr" <?= $_SESSION['lang'] === 'fr' ? 'selected' : '' ?>>Français</option>
            </select>
        </form>
    </div>
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
</body>

</html>