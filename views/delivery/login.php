<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Delivery Manager</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1>Sporshow</h1>
            <h2>Delivery Manager Portal</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login" id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Login</button>
            </form>
            <p class="login-hint">Delivery Manager Portal v1.0</p>
        </div>
    </div>
    <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value;
        if (!email || !password) {
            e.preventDefault();
            alert('Please fill in all fields.');
        }
    });
    </script>
</body>
</html>
