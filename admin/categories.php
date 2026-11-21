<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/helpers.php';

admin_require_login();

$type = isset($_REQUEST['type']) && $_REQUEST['type'] === 'gallery' ? 'gallery' : 'faq';

$definitions = [
    'faq' => [
        'config'  => 'faq',
        'section' => 'faq_categories',
        'label'   => 'FAQ',
        'active'  => 'faq',
        'nav'     => 'categories.php?type=faq',
    ],
    'gallery' => [
        'config'  => 'gallery',
        'section' => 'gallery_categories',
        'label'   => 'Gallery',
        'active'  => 'gallery',
        'nav'     => 'categories.php?type=gallery',
    ],
];

$def     = $definitions[$type];
$config  = admin_config();
$section = $def['section'];
$configKey = $def['config'];
$categories = isset($config[$configKey]['categories']) && is_array($config[$configKey]['categories']) ? $config[$configKey]['categories'] : [];
$items      = isset($config[$configKey]['items']) && is_array($config[$configKey]['items']) ? $config[$configKey]['items'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'add') {
        $name = trim((string) ($_POST['name'] ?? ''));
        if ($name === '') {
            admin_flash('error', 'Category name is required.');
        } else {
            $key = seo_slugify($name);
            if ($key === '') {
                $key = 'category';
            }
            $base = $key;
            $i = 2;
            while (isset($categories[$key])) {
                $key = $base . '-' . $i;
                $i++;
            }
            $categories[$key] = $name;
            if (content_store_save_section($section, $categories)) {
                admin_flash('success', $def['label'] . ' category created.');
            } else {
                admin_flash('error', 'Could not save the category. Check that data/ is writable.');
            }
        }
        admin_redirect($def['nav']);
    }

    if ($op === 'rename') {
        $key  = (string) ($_POST['key'] ?? '');
        $name = trim((string) ($_POST['name'] ?? ''));
        if (!isset($categories[$key])) {
            admin_flash('error', 'Category not found.');
        } elseif ($name === '') {
            admin_flash('error', 'Category name is required.');
        } else {
            $categories[$key] = $name;
            if (content_store_save_section($section, $categories)) {
                admin_flash('success', 'Category renamed.');
            } else {
                admin_flash('error', 'Could not save the category. Check that data/ is writable.');
            }
        }
        admin_redirect($def['nav']);
    }

    if ($op === 'delete') {
        $key = (string) ($_POST['key'] ?? '');
        if (!isset($categories[$key])) {
            admin_flash('error', 'Category not found.');
        } else {
            $usage = 0;
            foreach ($items as $item) {
                if (isset($item['category']) && $item['category'] === $key) {
                    $usage++;
                }
            }
            if ($usage > 0) {
                admin_flash('error', 'This category still has ' . $usage . ' item(s). Move or delete them first.');
            } else {
                unset($categories[$key]);
                if (content_store_save_section($section, $categories)) {
                    admin_flash('success', 'Category deleted.');
                } else {
                    admin_flash('error', 'Could not save the category. Check that data/ is writable.');
                }
            }
        }
        admin_redirect($def['nav']);
    }
}

admin_header($def['label'] . ' categories', $def['active']);
?>
<div class="admin-card">
    <h2 class="admin-title" style="font-size:1.05rem">Add category</h2>
    <form method="post" action="<?php echo e($def['nav']); ?>" class="admin-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="op" value="add">
        <div class="admin-field">
            <label for="new_name">Category name</label>
            <input type="text" id="new_name" name="name" required>
            <div class="admin-hint">The URL/filter key is generated from the name.</div>
        </div>
        <button type="submit" class="admin-btn">Create category</button>
    </form>
</div>

<div class="admin-card">
    <h2 class="admin-title" style="font-size:1.05rem">Existing categories</h2>
    <?php if (!$categories): ?>
        <p>No categories yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Key</th><th>Name</th><th>Items</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($categories as $key => $label): ?>
                        <?php
                        $usage = 0;
                        foreach ($items as $item) {
                            if (isset($item['category']) && $item['category'] === $key) {
                                $usage++;
                            }
                        }
                        ?>
                        <tr>
                            <td><code><?php echo e($key); ?></code></td>
                            <td>
                                <form method="post" action="<?php echo e($def['nav']); ?>" class="admin-actions">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="op" value="rename">
                                    <input type="hidden" name="key" value="<?php echo e($key); ?>">
                                    <input type="text" name="name" value="<?php echo e($label); ?>" required style="max-width:260px">
                                    <button type="submit" class="admin-btn admin-btn-sm admin-btn-light">Save</button>
                                </form>
                            </td>
                            <td><?php echo (int) $usage; ?></td>
                            <td>
                                <form method="post" action="<?php echo e($def['nav']); ?>" onsubmit="return confirm('Delete this category?');">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="op" value="delete">
                                    <input type="hidden" name="key" value="<?php echo e($key); ?>">
                                    <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger"<?php echo $usage > 0 ? ' disabled title="Move or delete its items first"' : ''; ?>>Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php
admin_footer();

