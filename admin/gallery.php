<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config     = admin_config();
$items      = isset($config['gallery']['items']) && is_array($config['gallery']['items']) ? $config['gallery']['items'] : [];
$categories = isset($config['gallery']['categories']) && is_array($config['gallery']['categories']) ? $config['gallery']['categories'] : [];
$action     = isset($_GET['action']) ? (string) $_GET['action'] : 'list';
$id         = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$error      = '';
$form       = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'delete') {
        $deleteId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        if (isset($items[$deleteId])) {
            array_splice($items, $deleteId, 1);
            if (content_store_save_section('gallery', $items)) {
                admin_flash('success', 'Gallery image removed.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('gallery.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $item = [
            'category' => (string) ($_POST['category'] ?? ''),
            'image'    => trim((string) ($_POST['image_path'] ?? '')),
            'alt'      => trim((string) ($_POST['alt'] ?? '')),
        ];

        try {
            $item['image'] = admin_handle_upload('image_file', $item['image']);
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }

        if ($error === '') {
            if (!isset($categories[$item['category']])) {
                $error = 'Choose a valid category.';
            } elseif ($item['image'] === '') {
                $error = 'Upload an image or enter an existing image path.';
            } elseif ($item['alt'] === '') {
                $error = 'Alt text is required for accessibility and SEO.';
            }
        }

        if ($error === '') {
            if ($editId >= 0 && isset($items[$editId])) {
                $items[$editId] = $item;
            } else {
                $items[] = $item;
            }

            if (content_store_save_section('gallery', $items)) {
                admin_flash('success', 'Gallery image saved.');
                admin_redirect('gallery.php');
            }
            $error = 'Could not save the image details. Check that data/ is writable.';
        }

        $form = $item;
        $id = $editId;
        $action = $editId >= 0 ? 'edit' : 'new';
    }
}

if ($action === 'new' || $action === 'edit') {
    if ($form === null) {
        if ($action === 'edit') {
            if (!isset($items[$id])) {
                admin_flash('error', 'Gallery item not found.');
                admin_redirect('gallery.php');
            }
            $form = $items[$id];
        } else {
            reset($categories);
            $form = ['category' => (string) key($categories), 'image' => '', 'alt' => ''];
        }
    }

    admin_header($action === 'edit' ? 'Edit gallery image' : 'Upload gallery image', 'gallery');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="gallery.php" enctype="multipart/form-data" class="admin-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="op" value="save">
            <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

            <div class="admin-field">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?php echo e($key); ?>"<?php echo $form['category'] === $key ? ' selected' : ''; ?>><?php echo e($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="admin-field">
                <label for="image_file">Image</label>
                <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                <div class="admin-hint">JPG, PNG, WEBP or GIF. Maximum 5 MB.</div>
            </div>
            <div class="admin-field">
                <label for="image_path">Or existing image path</label>
                <input type="text" id="image_path" name="image_path" value="<?php echo e($form['image']); ?>" placeholder="assets/images/gallery/campus-01.jpg">
            </div>
            <div class="admin-field">
                <label for="alt">Alt text</label>
                <input type="text" id="alt" name="alt" value="<?php echo e($form['alt']); ?>" required>
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save image</button>
                <a class="admin-btn admin-btn-light" href="gallery.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

$filter = isset($_GET['category']) ? (string) $_GET['category'] : '';

admin_header('Gallery', 'gallery');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="gallery.php?action=new">Upload image</a>
</div>
<div class="admin-card">
    <div class="admin-actions" style="margin-bottom:14px">
        <a class="admin-btn admin-btn-sm <?php echo $filter === '' ? '' : 'admin-btn-light'; ?>" href="gallery.php">All</a>
        <?php foreach ($categories as $key => $label): ?>
            <a class="admin-btn admin-btn-sm <?php echo $filter === $key ? '' : 'admin-btn-light'; ?>" href="gallery.php?category=<?php echo e($key); ?>"><?php echo e($label); ?></a>
        <?php endforeach; ?>
    </div>

    <?php
    $visible = [];
    foreach ($items as $index => $item) {
        if ($filter === '' || $item['category'] === $filter) {
            $visible[$index] = $item;
        }
    }
    ?>
    <?php if (!$visible): ?>
        <p>No images in this category.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Image</th><th>Category</th><th>Alt text</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($visible as $index => $item): ?>
                        <tr>
                            <td><img src="../<?php echo e($item['image']); ?>" alt=""></td>
                            <td><?php echo e(isset($categories[$item['category']]) ? $categories[$item['category']] : $item['category']); ?></td>
                            <td><?php echo e($item['alt']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="gallery.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="gallery.php" onsubmit="return confirm('Delete this gallery image?');">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="op" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int) $index; ?>">
                                        <button type="submit" class="admin-btn admin-btn-sm admin-btn-danger">Delete</button>
                                    </form>
                                </div>
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
