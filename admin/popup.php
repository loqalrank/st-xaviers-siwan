<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$popupPageList = [
    'index.php'              => 'Home',
    'about.php'              => 'About Us',
    'academics.php'          => 'Academics',
    'admissions.php'         => 'Admissions',
    'facilities.php'         => 'Facilities',
    'gallery.php'            => 'Gallery',
    'blog.php'               => 'Blog',
    'blog-detail.php'        => 'Blog Article',
    'contact.php'            => 'Contact Us',
    'faq.php'                => 'FAQs',
    'messages.php'           => 'Messages',
    'mandatory-disclosure.php' => 'Mandatory Disclosure',
];

$config   = admin_config();
$settings = isset($config['admission_popup']) && is_array($config['admission_popup']) ? $config['admission_popup'] : [];
$error    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $updated = $settings;
    $updated['enabled']            = !empty($_POST['enabled']);
    $updated['auto_open']          = !empty($_POST['auto_open']);
    $updated['auto_close_seconds'] = max(0, min(600, (int) ($_POST['auto_close_seconds'] ?? 30)));
    $selectedPages = isset($_POST['pages']) && is_array($_POST['pages']) ? array_map('strval', $_POST['pages']) : [];
    $updated['pages'] = array_values(array_intersect($selectedPages, array_keys($popupPageList)));
    $updated['eyebrow']            = trim((string) ($_POST['eyebrow'] ?? ''));
    $updated['year']               = trim((string) ($_POST['year'] ?? ''));
    $updated['title']              = trim((string) ($_POST['title'] ?? ''));
    $updated['title_accent']       = trim((string) ($_POST['title_accent'] ?? ''));
    $updated['subline']            = trim((string) ($_POST['subline'] ?? ''));
    $updated['cta_label']          = trim((string) ($_POST['cta_label'] ?? ''));
    $updated['image']              = trim((string) ($_POST['image_path'] ?? ''));

    try {
        $updated['image'] = admin_handle_upload('image_file', $updated['image']);
    } catch (RuntimeException $ex) {
        $error = $ex->getMessage();
    }

    if ($error === '') {
        if ($updated['title'] === '') {
            $error = 'Main title is required.';
        } elseif ($updated['image'] === '') {
            $error = 'Upload an image or keep an existing image path.';
        }
    }

    if ($error === '') {
        if (content_store_save_section('admission_popup', $updated)) {
            admin_flash('success', 'Admission popup settings saved.');
            admin_redirect('popup.php');
        }
        $error = 'Could not save settings. Check that data/ is writable.';
    }

    $settings = $updated;
}

$image = isset($settings['image']) ? $settings['image'] : 'assets/images/hero-students.jpg';

admin_header('Admission popup', 'popup');
?>
<?php if ($error !== ''): ?>
    <div class="admin-alert is-error"><?php echo e($error); ?></div>
<?php endif; ?>

<div class="admin-card">
    <form method="post" action="popup.php" enctype="multipart/form-data" class="admin-form">
        <?php echo csrf_field(); ?>

        <div class="admin-field">
            <label><input type="checkbox" name="enabled" value="1"<?php echo !empty($settings['enabled']) ? ' checked' : ''; ?>> Show the admission popup on the website</label>
        </div>
        <div class="admin-field">
            <label><input type="checkbox" name="auto_open" value="1"<?php echo !empty($settings['auto_open']) ? ' checked' : ''; ?>> Open automatically on page load</label>
            <div class="admin-hint">It opens on every page load. Visitors can always close it manually.</div>
        </div>
        <div class="admin-field">
            <label for="auto_close_seconds">Auto-close after (seconds)</label>
            <input type="number" id="auto_close_seconds" name="auto_close_seconds" min="0" max="600" value="<?php echo (int) (isset($settings['auto_close_seconds']) ? $settings['auto_close_seconds'] : 30); ?>" style="max-width:160px">
            <div class="admin-hint">Use 0 to keep it open until the visitor closes it.</div>
        </div>

        <div class="admin-field">
            <label>Show popup on these pages</label>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:6px 18px">
                <?php
                $selectedPages = isset($settings['pages']) && is_array($settings['pages']) ? $settings['pages'] : array_keys($popupPageList);
                foreach ($popupPageList as $pageFile => $pageLabel):
                ?>
                    <label style="font-weight:500;margin:0"><input type="checkbox" name="pages[]" value="<?php echo e($pageFile); ?>"<?php echo in_array($pageFile, $selectedPages, true) ? ' checked' : ''; ?>> <?php echo e($pageLabel); ?></label>
                <?php endforeach; ?>
            </div>
            <div class="admin-hint">Leave all unchecked to show the popup on every page.</div>
        </div>

        <div class="admin-field">
            <label for="eyebrow">Small label</label>
            <input type="text" id="eyebrow" name="eyebrow" value="<?php echo e($settings['eyebrow'] ?? 'Admissions Open'); ?>">
        </div>
        <div class="admin-field">
            <label for="year">Session / year</label>
            <input type="text" id="year" name="year" value="<?php echo e($settings['year'] ?? ''); ?>" placeholder="2026–27">
        </div>
        <div class="admin-field">
            <label for="title">Main title</label>
            <input type="text" id="title" name="title" value="<?php echo e($settings['title'] ?? ''); ?>" required>
        </div>
        <div class="admin-field">
            <label for="title_accent">Highlighted word</label>
            <input type="text" id="title_accent" name="title_accent" value="<?php echo e($settings['title_accent'] ?? ''); ?>">
            <div class="admin-hint">Displayed under the main title in the accent colour.</div>
        </div>
        <div class="admin-field">
            <label for="subline">Description</label>
            <textarea id="subline" name="subline"><?php echo e($settings['subline'] ?? ''); ?></textarea>
        </div>
        <div class="admin-field">
            <label for="cta_label">Button label</label>
            <input type="text" id="cta_label" name="cta_label" value="<?php echo e($settings['cta_label'] ?? ''); ?>" placeholder="Call Now">
        </div>

        <div class="admin-field">
            <label for="image_path">Image path</label>
            <input type="text" id="image_path" name="image_path" value="<?php echo e($image); ?>">
            <div class="admin-hint">Current image:</div>
            <img src="../<?php echo e($image); ?>" alt="" style="max-width:220px;border-radius:10px;margin-top:8px;display:block">
        </div>
        <div class="admin-field">
            <label for="image_file">Replace image</label>
            <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
            <div class="admin-hint">JPG, PNG, WEBP or GIF. Maximum 5 MB.</div>
        </div>

        <div class="admin-actions">
            <button type="submit" class="admin-btn">Save settings</button>
            <a class="admin-btn admin-btn-light" href="../index.php" target="_blank" rel="noopener">Preview website</a>
        </div>
    </form>
</div>
<?php
admin_footer();
