<?php $path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/login.css">
</head>

<body>
    <header>
        <div class="store-name" style="color: red; font-style: italic;">Depanneur du Souvenir</div>
    </header>

    <div class="login-container">
        <img src="<?= $dirname ?>/images/defaultguy.jpg" alt="User Icon" class="user-icon">

        <h2><?=LOGIN?></h2>
        <form method="POST" action="<?= $path ?>">
            <input type="text" name="username" placeholder="<?=USERNAME?>" required>
            <input type="password" name="password" placeholder="<?=PASSWORD?>" required>
            <button type="submit"><?=LOGIN?></button>
        </form>
    </div>

    <div class="language-switch">
        <form method="POST" action="">
            <select name="lang" onchange="this.form.submit()">
                <option value="en" <?= $_SESSION['lang'] === 'en' ? 'selected' : '' ?>>English</option>
                <option value="fr" <?= $_SESSION['lang'] === 'fr' ? 'selected' : '' ?>>Français</option>
            </select>
        </form>
    </div>
</body>

</html>