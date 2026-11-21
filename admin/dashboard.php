<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config = admin_config();
$creds  = admin_credentials();
require_once __DIR__ . '/includes/leads-store.php';
$leads = leads_all();
$newLeads = 0;
foreach ($leads as $lead) {
    if (($lead['status'] ?? 'new') === 'new') {
        $newLeads++;
    }
}
$counts = [
    'New leads'  => $newLeads,
    'All leads'  => count($leads),
    'Blog posts' => isset($config['blog']['posts']) ? count($config['blog']['posts']) : 0,
    'FAQs'       => isset($config['faq']['items']) ? count($config['faq']['items']) : 0,
    'Gallery'    => isset($config['gallery']['items']) ? count($config['gallery']['items']) : 0,
    'Toppers'    => isset($config['toppers']['toppers']) ? count($config['toppers']['toppers']) : 0,
];

admin_header('Dashboard', 'dashboard');
?>
<?php if ($creds && $creds['must_change']): ?>
    <div class="admin-alert is-error">You are still using the default password. <a href="settings.php">Change it now</a>.</div>
<?php endif; ?>

<div class="admin-grid">
    <?php foreach ($counts as $label => $count): ?>
        <div class="admin-stat">
            <span><?php echo e($label); ?></span>
            <strong><?php echo (int) $count; ?></strong>
        </div>
    <?php endforeach; ?>
</div>

<div class="admin-card">
    <h2 class="admin-title" style="font-size:1.1rem">Manage content</h2>
    <div class="admin-actions">
        <a class="admin-btn" href="leads.php">View leads</a>
        <a class="admin-btn" href="blog.php?action=new">New blog post</a>
        <a class="admin-btn" href="faq.php?action=new">New FAQ</a>
        <a class="admin-btn" href="gallery.php?action=new">Upload gallery image</a>
        <a class="admin-btn" href="toppers.php?action=new">Add topper</a>
    </div>
    <p class="admin-hint" style="margin-top:14px">Saved changes appear on the public website immediately.</p>
</div>
<?php
admin_footer();
