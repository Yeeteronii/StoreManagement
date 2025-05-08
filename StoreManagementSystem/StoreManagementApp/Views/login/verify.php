<?php $path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify 2FA</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/login.css">
</head>
<body>
    <h2>Enter your Google Authenticator code</h2>
    
    <form method="POST" action="?action=verify">
        <input type="text" name="code" placeholder="Enter 6-digit code" required>
        <button type="submit">Verify</button>
        <?php if (isset($_SESSION['login_error'])): ?>
            <p style="color:red;"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
        <?php endif; ?>
    </form>

    <form method="POST" action="?action=resend" style="margin-top: 10px;">
        <button type="submit">Resend Code</button>
    </form>

    <form method="POST" action="?action=reset" style="margin-top: 10px;">
        <button type="submit">Back to Login</button>
    </form>
</body>
</html>
