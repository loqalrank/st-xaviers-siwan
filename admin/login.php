<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (admin_user() !== null) {
    admin_redirect('dashboard.php');
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $lockUntil = isset($_SESSION['admin_lock_until']) ? (int) $_SESSION['admin_lock_until'] : 0;
    if ($lockUntil > time()) {
        $error = 'Too many failed attempts. Please try again in a few minutes.';
    } else {
        $username = isset($_POST['username']) ? trim((string) $_POST['username']) : '';
        $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

        if ($username === '' || $password === '') {
            $error = 'Enter both username and password.';
        } elseif (admin_login($username, $password)) {
            unset($_SESSION['admin_login_fails'], $_SESSION['admin_lock_until']);
            admin_redirect('dashboard.php');
        } else {
            $fails = isset($_SESSION['admin_login_fails']) ? (int) $_SESSION['admin_login_fails'] : 0;
            $fails++;
            if ($fails >= 5) {
                $_SESSION['admin_login_fails'] = 0;
                $_SESSION['admin_lock_until'] = time() + 300;
                $error = 'Too many failed attempts. Please try again in a few minutes.';
            } else {
                $_SESSION['admin_login_fails'] = $fails;
                $error = 'Invalid username or password.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | St. Xavier's High School</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
    <main class="admin-login">
        <div class="admin-login-card">
            <img src="../assets/images/school-logo.png" alt="St. Xavier's High School logo">
            <h1>Admin Login</h1>
            <p>Sign in to manage blog posts, FAQs, gallery images and toppers.</p>

            <?php if ($error !== ''): ?>
                <div class="admin-alert is-error"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="post" action="login.php" class="admin-form">
                <?php echo csrf_field(); ?>
                <div class="admin-field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo e($username); ?>" autocomplete="username" required autofocus>
                </div>
                <div class="admin-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required>
                </div>
                <button type="submit" class="admin-btn">Sign in</button>
            </form>
        </div>
    </main>
</body>
</html>
