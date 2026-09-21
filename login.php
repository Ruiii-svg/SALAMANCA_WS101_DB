<?php
session_start();
require __DIR__ . '/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, full_name, email, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email']     = $user['email'];
            header('Location: home.php');
            exit;
        }

        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In &mdash; Nature of the Philippines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-login">
    <div class="page-wrapper login-page">
        <div class="page-container">
            <div class="login-card">
                <h1 class="login-heading">Welcome</h1>
                <p class="login-subtitle">Log in to explore Philippines</p>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter you Email Address"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrap">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">Show</button>
                        </div>
                    </div>

                    <div class="login-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                    </div>

                    <button type="submit" class="login-btn">Log In</button>
                </form>

                <div class="login-card login-footer">
                    Don't have an account? <a href="register.php">Create one</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const btn = document.querySelector('.password-toggle');
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = 'Hide';
            } else {
                input.type = 'password';
                btn.textContent = 'Show';
            }
        }
    </script>
</body>
</html>