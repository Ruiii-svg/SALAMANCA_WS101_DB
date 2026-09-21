<?php
session_start();
require __DIR__ . '/config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $error = 'An account with this email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute([
                'name'     => $fullName,
                'email'    => $email,
                'password' => $hash,
            ]);

            $_SESSION['user_id']   = (int) $pdo->lastInsertId();
            $_SESSION['full_name'] = $fullName;
            $_SESSION['email']     = $email;

            header('Location: home.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account &mdash; Nature of the Philippines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-login">
    <div class="page-wrapper login-page">
        <div class="page-container">
            <div class="login-card">
                <h1 class="login-heading">Create Account</h1>
                <p class="login-subtitle">Join and explore the Philippines</p>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post" action="register.php">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name"
                               value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrap">
                            <input type="password" id="password" name="password" placeholder="At least 8 characters" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">Show</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="password-wrap">
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">Show</button>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">Create Account</button>
                </form>

                <div class="login-card login-footer">
                    Already have an account? <a href="login.php">Log in</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id || 'password');
            const btn = input.parentElement.querySelector('.password-toggle');
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