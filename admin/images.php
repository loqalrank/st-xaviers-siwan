<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config = admin_config();
$images = isset($config['site_images']) && is_array($config['site_images']) ? $config['site_images'] : [];
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op  = isset($_POST['op']) ? (string) $_POST['op'] : '';
    $key = isset($_POST['key']) ? (string) $_POST['key'] : '';

    if ($op === 'save_image' && isset($images[$key])) {
        $path = trim((string) ($_POST['image_path'] ?? ''));

        try {
            $path = admin_handle_upload('image_file', $path);
        } catch (RuntimeException $ex) {
            admin_flash('error', $ex->getMessage());
            admin_redirect('images.php');
        }

        if ($path === '') {
            admin_flash('error', 'Upload an image or keep an existing path.');
        } elseif (!preg_match('~^(assets/|/)~', $path)) {
            admin_flash('error', 'Image path must start with assets/ or /.');
        } else {
            $saved = content_store_read();
            $map = isset($saved['site_images']) && is_array($saved['site_images']) ? $saved['site_images'] : [];
            $map[$key] = $path;

            if (content_store_save_section('site_images', $map)) {
                admin_flash('success', 'Image updated: ' . $images[$key]['label']);
            } else {
                admin_flash('error', 'Could not save the image. Check that data/ is writable.');
            }
        }
        admin_redirect('images.php');
    }
}

admin_header('Site images', 'images');
?>
<div class="admin-card">
    <p class="admin-hint" style="margin-top:0">Section images used across the website. Hero slides, blog images, gallery, toppers, admission popup and disclosure PDFs are managed in their own sections.</p>
</div>

<div class="admin-grid" style="grid-template-columns:repeat(auto-fit,minmax(300px,1fr))">
    <?php foreach ($images as $key => $image): ?>
        <?php $path = isset($image['path']) ? $image['path'] : ''; ?>
        <div class="admin-card" style="margin-bottom:0">
            <h2 class="admin-title" style="font-size:1rem;margin-bottom:10px"><?php echo e($image['label'] ?? $key); ?></h2>
            <?php if ($path !== ''): ?>
                <img src="../<?php echo e($path); ?>" alt="" style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:12px;display:block">
            <?php endif; ?>
            <form method="post" action="images.php" enctype="multipart/form-data" class="admin-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="op" value="save_image">
                <input type="hidden" name="key" value="<?php echo e($key); ?>">
                <div class="admin-field">
                    <label for="file-<?php echo e($key); ?>">Replace image</label>
                    <input type="file" id="file-<?php echo e($key); ?>" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                </div>
                <div class="admin-field">
                    <label for="path-<?php echo e($key); ?>">Image path</label>
                    <input type="text" id="path-<?php echo e($key); ?>" name="image_path" value="<?php echo e($path); ?>">
                </div>
                <button type="submit" class="admin-btn admin-btn-sm">Save image</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<?php
admin_footer();
