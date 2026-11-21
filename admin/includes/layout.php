<?php
/**
 * Shared admin layout.
 */

function admin_header(string $title, string $active = ''): void
{
    $user = admin_user();
    $nav  = [
        'dashboard' => ['Dashboard', 'dashboard.php'],
        'leads'     => ['Leads', 'leads.php'],
        'blog'      => ['Blog Posts', 'blog.php'],
        'faq'       => ['FAQs', 'faq.php'],
        'faq-categories' => ['FAQ Categories', 'categories.php?type=faq'],
        'gallery'   => ['Gallery', 'gallery.php'],
        'gallery-categories' => ['Gallery Categories', 'categories.php?type=gallery'],
        'toppers'   => ['Toppers', 'toppers.php'],
        'disclosure' => ['Disclosure PDFs', 'disclosure.php'],
        'hero'      => ['Hero Section', 'hero.php'],
        'images'    => ['Site Images', 'images.php'],
        'popup'     => ['Admission Popup', 'popup.php'],
        'settings'  => ['Account', 'settings.php'],
    ];
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo e($title); ?> | School Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="icon" type="image/png" href="../assets/images/school-logo.png">
</head>
<body class="admin-body">
    <header class="admin-topbar">
        <div class="admin-brand">
            <img src="../assets/images/school-logo.png" alt="">
            <span>School Admin</span>
        </div>
        <div class="admin-user">
            <span><?php echo e((string) $user); ?></span>
            <form method="post" action="logout.php">
                <?php echo csrf_field(); ?>
                <button type="submit" class="admin-btn admin-btn-light">Log out</button>
            </form>
        </div>
    </header>
    <div class="admin-shell">
        <nav class="admin-nav" aria-label="Admin sections">
            <?php foreach ($nav as $key => $item): ?>
                <a href="<?php echo e($item[1]); ?>"<?php echo $active === $key ? ' class="is-active"' : ''; ?>><?php echo e($item[0]); ?></a>
            <?php endforeach; ?>
            <a href="../index.php" target="_blank" rel="noopener">View website</a>
        </nav>
        <main class="admin-main">
            <h1 class="admin-title"><?php echo e($title); ?></h1>
            <?php foreach (admin_flash_all() as $flash): ?>
                <div class="admin-alert <?php echo $flash['type'] === 'error' ? 'is-error' : 'is-success'; ?>"><?php echo e($flash['message']); ?></div>
            <?php endforeach; ?>
<?php
}

function admin_footer(): void
{
    ?>
        </main>
    </div>
</body>
</html>
<?php
}
