<link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/login.css">
<h2>Scan this QR Code with Google Authenticator</h2>
<img src="<?= $qrCodeUrl ?>" alt="Scan this QR with Google Authenticator">
<form method="POST" action="?action=verify2fa">
    <input type="text" name="code" placeholder="Enter 6-digit code" required>
    <button type="submit">Verify</button>
</form>