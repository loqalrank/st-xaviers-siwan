<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$creds = admin_credentials();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $current = isset($_POST['current_password']) ? (string) $_POST['current_password'] : '';
    $new     = isset($_POST['new_password']) ? (string) $_POST['new_password'] : '';
    $confirm = isset($_POST['confirm_password']) ? (string) $_POST['confirm_password'] : '';

    if (!$creds || !password_verify($current, $creds['password_hash'])) {
        $error = 'Current password is incorrect.';
    } elseif (strlen($new) < 8) {
        $error = 'New password must be at least 8 characters.';
    } elseif ($new !== $confirm) {
        $error = 'New password and confirmation do not match.';
    } elseif (admin_write_json(admin_credentials_path(), [
        'username'      => $creds['username'],
        'password_hash' => password_hash($new, PASSWORD_DEFAULT),
        'must_change'   => false,
        'updated_at'    => date('c'),
    ])) {
        admin_flash('success', 'Password updated successfully.');
        admin_redirect('settings.php');
    } else {
        $error = 'Could not save the new password. Check that data/ is writable.';
    }
}

admin_header('Account', 'settings');
?>
<?php if ($error !== ''): ?>
    <div class="admin-alert is-error"><?php echo e($error); ?></div>
<?php endif; ?>

<div class="admin-card">
    <form method="post" action="settings.php" class="admin-form">
        <?php echo csrf_field(); ?>
        <div class="admin-field">
            <label for="current_password">Current password</label>
            <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
        </div>
        <div class="admin-field">
            <label for="new_password">New password</label>
            <input type="password" id="new_password" name="new_password" autocomplete="new-password" minlength="8" required>
            <div class="admin-hint">Use at least 8 characters.</div>
        </div>
        <div class="admin-field">
            <label for="confirm_password">Confirm new password</label>
            <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" minlength="8" required>
        </div>
        <button type="submit" class="admin-btn">Update password</button>
    </form>
</div>
<?php
admin_footer();
