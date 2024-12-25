<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/assets/styles/loginPage.css">
</head>
<body>
    <h1>Вход</h1>
        <?php 
            if (isset($_SESSION['error'])) {
                $message = $_SESSION['error'];
                echo "<script>alert('$message');</script>";
                unset($_SESSION['error']);
            };
        ?>
    <form method="POST" action="/handleLogin" class="login-form">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login-button">Войти</button>
    </form>
</body>
</html>
