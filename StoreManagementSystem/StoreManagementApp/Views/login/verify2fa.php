<link rel="stylesheet" href="/StoreManagement/StoreManagementSystem/StoreManagementApp/Views/styles/login.css">
<h2>Enter your Google Authenticator code</h2>
<form method="POST" action="?action=verify2fa">
    <input type="text" name="code" placeholder="Enter 6-digit code" required>
    <button type="submit">Verify</button>
    <?php if (isset($_SESSION['login_error'])): ?>
        <p style="color:red;"><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php endif; ?>
</form>
