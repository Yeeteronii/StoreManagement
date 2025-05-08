<?php $path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);?>
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
    <img src="/StoreManagement/StoreManagementSystem/StoreManagementApp/images/defaultguy.jpg" alt="User Icon" class="user-icon">

    <h2>Login</h2>
    <form method="POST" action="<?= $path ?>">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

<div class="language-switch">
    <select>
        <option value="en">English</option>
        <option value="fr">Français</option>
    </select>
</div>
</body>
</html>