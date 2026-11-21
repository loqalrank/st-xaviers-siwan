<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$pageLinks = [
    'index.php'              => 'Home',
    'about.php'              => 'About Us',
    'academics.php'          => 'Academics',
    'admissions.php'         => 'Admissions',
    'facilities.php'         => 'Facilities',
    'gallery.php'            => 'Gallery',
    'blog.php'               => 'Blog',
    'contact.php'            => 'Contact Us',
    'faq.php'                => 'FAQs',
    'messages.php'           => 'Messages',
    'mandatory-disclosure.php' => 'Mandatory Disclosure',
];

$config = admin_config();
$slides = isset($config['hero']['slides']) && is_array($config['hero']['slides']) ? $config['hero']['slides'] : [];
$action = isset($_GET['action']) ? (string) $_GET['action'] : 'list';
$id     = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$error  = '';
$form   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'delete') {
        $deleteId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        if (isset($slides[$deleteId])) {
            array_splice($slides, $deleteId, 1);
            if (content_store_save_section('hero_slides', $slides)) {
                admin_flash('success', 'Hero slide deleted.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('hero.php');
    }

    if ($op === 'move') {
        $moveId  = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $direction = isset($_POST['direction']) && $_POST['direction'] === 'up' ? -1 : 1;
        $target  = $moveId + $direction;
        if (isset($slides[$moveId], $slides[$target])) {
            $tmp = $slides[$moveId];
            $slides[$moveId] = $slides[$target];
            $slides[$target] = $tmp;
            if (content_store_save_section('hero_slides', $slides)) {
                admin_flash('success', 'Slide order updated.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('hero.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $slide = [
            'image'         => trim((string) ($_POST['image_path'] ?? '')),
            'image_alt'     => trim((string) ($_POST['image_alt'] ?? '')),
            'tag'           => trim((string) ($_POST['tag'] ?? '')),
            'title'         => trim((string) ($_POST['title'] ?? '')),
            'description'   => trim((string) ($_POST['description'] ?? '')),
            'button_label'  => trim((string) ($_POST['button_label'] ?? '')),
            'button_link'   => trim((string) ($_POST['button_link'] ?? '')),
            'button2_label' => trim((string) ($_POST['button2_label'] ?? '')),
            'button2_link'  => trim((string) ($_POST['button2_link'] ?? '')),
            'sticker_title' => trim((string) ($_POST['sticker_title'] ?? '')),
            'sticker_text'  => trim((string) ($_POST['sticker_text'] ?? '')),
        ];

        try {
            $slide['image'] = admin_handle_upload('image_file', $slide['image']);
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }

        if ($error === '') {
            if ($slide['image'] === '') {
                $error = 'Upload an image or enter an image path.';
            } elseif ($slide['title'] === '') {
                $error = 'Heading is required.';
            } elseif ($slide['button_label'] !== '' && $slide['button_link'] === '') {
                $error = 'Choose a page for the primary button.';
            } elseif ($slide['button_link'] !== '' && !isset($pageLinks[$slide['button_link']])) {
                $error = 'Choose a valid page for the primary button.';
            } elseif ($slide['button2_label'] !== '' && $slide['button2_link'] === '') {
                $error = 'Choose a page for the secondary button.';
            } elseif ($slide['button2_link'] !== '' && !isset($pageLinks[$slide['button2_link']])) {
                $error = 'Choose a valid page for the secondary button.';
            }
        }

        if ($error === '') {
            if ($slide['image_alt'] === '') {
                $slide['image_alt'] = $slide['tag'] !== '' ? $slide['tag'] : $slide['title'];
            }
            if ($editId >= 0 && isset($slides[$editId])) {
                $slides[$editId] = $slide;
            } else {
                $slides[] = $slide;
            }

            if (content_store_save_section('hero_slides', $slides)) {
                admin_flash('success', 'Hero slide saved.');
                admin_redirect('hero.php');
            }
            $error = 'Could not save the slide. Check that data/ is writable.';
        }

        $form = $slide;
        $id = $editId;
        $action = $editId >= 0 ? 'edit' : 'new';
    }
}

if ($action === 'new' || $action === 'edit') {
    if ($form === null) {
        if ($action === 'edit') {
            if (!isset($slides[$id])) {
                admin_flash('error', 'Hero slide not found.');
                admin_redirect('hero.php');
            }
            $form = $slides[$id];
        } else {
            $form = [
                'image' => '', 'image_alt' => '', 'tag' => '', 'title' => '',
                'description' => '', 'button_label' => '', 'button_link' => '',
                'button2_label' => '', 'button2_link' => '', 'sticker_title' => '', 'sticker_text' => '',
            ];
        }
    }
    $form += ['sticker_title' => '', 'sticker_text' => '', 'button2_label' => '', 'button2_link' => ''];

    admin_header($action === 'edit' ? 'Edit hero slide' : 'New hero slide', 'hero');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="hero.php" enctype="multipart/form-data" class="admin-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="op" value="save">
            <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

            <div class="admin-field">
                <label for="image_file">Background image</label>
                <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                <div class="admin-hint">JPG, PNG, WEBP or GIF. Maximum 5 MB. Landscape images work best.</div>
            </div>
            <div class="admin-field">
                <label for="image_path">Or existing image path</label>
                <input type="text" id="image_path" name="image_path" value="<?php echo e($form['image']); ?>" placeholder="assets/images/hero-learning-with-purpose.jpg">
                <?php if ($form['image'] !== ''): ?>
                    <img src="../<?php echo e($form['image']); ?>" alt="" style="max-width:260px;border-radius:10px;margin-top:8px;display:block">
                <?php endif; ?>
            </div>
            <div class="admin-field">
                <label for="image_alt">Image alt text</label>
                <input type="text" id="image_alt" name="image_alt" value="<?php echo e($form['image_alt']); ?>">
            </div>
            <div class="admin-field">
                <label for="tag">Small label</label>
                <input type="text" id="tag" name="tag" value="<?php echo e($form['tag']); ?>" placeholder="Learning with purpose">
            </div>
            <div class="admin-field">
                <label for="title">Heading</label>
                <textarea id="title" name="title" required placeholder="Building Knowledge.&#10;Inspiring Excellence.&#10;Shaping Futures."><?php echo e($form['title']); ?></textarea>
                <div class="admin-hint">One line per line break. The last line is highlighted in the accent colour.</div>
            </div>
            <div class="admin-field">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo e($form['description']); ?></textarea>
            </div>
            <div class="admin-field">
                <label for="button_label">Primary button label</label>
                <input type="text" id="button_label" name="button_label" value="<?php echo e($form['button_label']); ?>">
            </div>
            <div class="admin-field">
                <label for="button_link">Primary button page</label>
                <select id="button_link" name="button_link">
                    <option value="">Select a page</option>
                    <?php foreach ($pageLinks as $linkValue => $linkLabel): ?>
                        <option value="<?php echo e($linkValue); ?>"<?php echo $form['button_link'] === $linkValue ? ' selected' : ''; ?>><?php echo e($linkLabel); ?></option>
                    <?php endforeach; ?>
                    <?php if ($form['button_link'] !== '' && !isset($pageLinks[$form['button_link']])): ?>
                        <option value="<?php echo e($form['button_link']); ?>" selected>Current: <?php echo e($form['button_link']); ?></option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="admin-field">
                <label for="button2_label">Secondary button label (optional)</label>
                <input type="text" id="button2_label" name="button2_label" value="<?php echo e($form['button2_label']); ?>">
            </div>
            <div class="admin-field">
                <label for="button2_link">Secondary button page</label>
                <select id="button2_link" name="button2_link">
                    <option value="">Select a page</option>
                    <?php foreach ($pageLinks as $linkValue => $linkLabel): ?>
                        <option value="<?php echo e($linkValue); ?>"<?php echo $form['button2_link'] === $linkValue ? ' selected' : ''; ?>><?php echo e($linkLabel); ?></option>
                    <?php endforeach; ?>
                    <?php if ($form['button2_link'] !== '' && !isset($pageLinks[$form['button2_link']])): ?>
                        <option value="<?php echo e($form['button2_link']); ?>" selected>Current: <?php echo e($form['button2_link']); ?></option>
                    <?php endif; ?>
                </select>
            </div>
            <div class="admin-field">
                <label for="sticker_title">Sticker bold text (optional)</label>
                <input type="text" id="sticker_title" name="sticker_title" value="<?php echo e($form['sticker_title']); ?>">
            </div>
            <div class="admin-field">
                <label for="sticker_text">Sticker text (optional)</label>
                <input type="text" id="sticker_text" name="sticker_text" value="<?php echo e($form['sticker_text']); ?>">
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save slide</button>
                <a class="admin-btn admin-btn-light" href="hero.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

admin_header('Hero section', 'hero');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="hero.php?action=new">Add slide</a>
    <a class="admin-btn admin-btn-light" href="../index.php" target="_blank" rel="noopener">Preview homepage</a>
</div>
<div class="admin-card">
    <?php if (!$slides): ?>
        <p>No hero slides yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Image</th><th>Heading</th><th>Label</th><th>Order</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($slides as $index => $slide): ?>
                        <?php $firstLine = strtok((string) $slide['title'], "\r\n"); ?>
                        <tr>
                            <td><img src="../<?php echo e($slide['image']); ?>" alt=""></td>
                            <td><?php echo e($firstLine !== false ? $firstLine : ''); ?></td>
                            <td><?php echo e($slide['tag']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <form method="post" action="hero.php">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="op" value="move">
                                        <input type="hidden" name="id" value="<?php echo (int) $index; ?>">
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" class="admin-btn admin-btn-sm admin-btn-light"<?php echo $index === 0 ? ' disabled' : ''; ?>>Up</button>
                                    </form>
                                    <form method="post" action="hero.php">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="op" value="move">
                                        <input type="hidden" name="id" value="<?php echo (int) $index; ?>">
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" class="admin-btn admin-btn-sm admin-btn-light"<?php echo $index === count($slides) - 1 ? ' disabled' : ''; ?>>Down</button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="hero.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="hero.php" onsubmit="return confirm('Delete this slide?');">
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
