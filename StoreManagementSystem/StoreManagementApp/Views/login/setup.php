<?php $path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup 2FA</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/login.css">
</head>
<body>
    <h2>Scan this QR Code with Google Authenticator</h2>
    <img src="<?= $qrCodeUrl ?>" alt="Scan this QR with Google Authenticator">
    
    <form method="POST" action="?action=verify">
        <input type="text" name="code" placeholder="Enter 6-digit code" required>
        <button type="submit">Verify</button>
    </form>

    <form method="POST" action="?action=reset" style="margin-top: 10px;">
        <button type="submit">Back to Login</button>
    </form>
</body>
</html>