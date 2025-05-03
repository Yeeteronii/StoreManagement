<?php $path = $_SERVER['SCRIPT_NAME']; ?>
<html>
<head>
    <title>Login</title>
    <style>
        label { display: inline-block; width: 100px; }
    </style>
</head>
<body>
<form method="POST">
    <h2>Login</h2>
    <label>Username:</label>
    <input type="text" name="username"><br>

    <label>Password:</label>
    <input type="password" name="password"><br><br>

    <input type="submit" value="Login">
    <br><br>
</form>
</body>
</html>
