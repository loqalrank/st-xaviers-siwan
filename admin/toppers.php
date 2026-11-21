<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config = admin_config();
$items  = isset($config['toppers']['toppers']) && is_array($config['toppers']['toppers']) ? $config['toppers']['toppers'] : [];
$action = isset($_GET['action']) ? (string) $_GET['action'] : 'list';
$id     = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$error  = '';
$form   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'delete') {
        $deleteId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        if (isset($items[$deleteId])) {
            array_splice($items, $deleteId, 1);
            if (content_store_save_section('toppers', $items)) {
                admin_flash('success', 'Topper removed.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('toppers.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $item = [
            'name'  => trim((string) ($_POST['name'] ?? '')),
            'class' => trim((string) ($_POST['class'] ?? '')),
            'score' => trim((string) ($_POST['score'] ?? '')),
            'image' => trim((string) ($_POST['image_path'] ?? '')),
            'note'  => trim((string) ($_POST['note'] ?? '')),
        ];

        try {
            $item['image'] = admin_handle_upload('image_file', $item['image']);
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }

        if ($error === '') {
            if ($item['name'] === '') {
                $error = 'Student name is required.';
            } elseif ($item['score'] === '') {
                $error = 'Score is required.';
            } elseif ($item['image'] === '') {
                $error = 'Upload a photo or enter an existing image path.';
            }
        }

        if ($error === '') {
            if ($editId >= 0 && isset($items[$editId])) {
                $items[$editId] = $item;
            } else {
                $items[] = $item;
            }

            if (content_store_save_section('toppers', $items)) {
                admin_flash('success', 'Topper saved.');
                admin_redirect('toppers.php');
            }
            $error = 'Could not save the topper. Check that data/ is writable.';
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
                admin_flash('error', 'Topper not found.');
                admin_redirect('toppers.php');
            }
            $form = $items[$id];
        } else {
            $form = ['name' => '', 'class' => 'Class X', 'score' => '', 'image' => '', 'note' => ''];
        }
    }

    admin_header($action === 'edit' ? 'Edit topper' : 'Add topper', 'toppers');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="toppers.php" enctype="multipart/form-data" class="admin-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="op" value="save">
            <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

            <div class="admin-field">
                <label for="name">Student name</label>
                <input type="text" id="name" name="name" value="<?php echo e($form['name']); ?>" required>
            </div>
            <div class="admin-field">
                <label for="class">Class</label>
                <input type="text" id="class" name="class" value="<?php echo e($form['class']); ?>" placeholder="Class X">
            </div>
            <div class="admin-field">
                <label for="score">Score</label>
                <input type="text" id="score" name="score" value="<?php echo e($form['score']); ?>" placeholder="95%" required>
            </div>
            <div class="admin-field">
                <label for="note">Note</label>
                <input type="text" id="note" name="note" value="<?php echo e($form['note']); ?>" placeholder="School Topper">
            </div>
            <div class="admin-field">
                <label for="image_file">Photo</label>
                <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                <div class="admin-hint">JPG, PNG, WEBP or GIF. Maximum 5 MB. Existing photo: <?php echo e($form['image'] !== '' ? $form['image'] : 'none'); ?></div>
            </div>
            <div class="admin-field">
                <label for="image_path">Or existing photo path</label>
                <input type="text" id="image_path" name="image_path" value="<?php echo e($form['image']); ?>" placeholder="assets/images/toppers/01_Anshika_Verma.png">
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save topper</button>
                <a class="admin-btn admin-btn-light" href="toppers.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

admin_header('Toppers', 'toppers');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="toppers.php?action=new">Add topper</a>
</div>
<div class="admin-card">
    <?php if (!$items): ?>
        <p>No toppers yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Photo</th><th>Name</th><th>Class</th><th>Score</th><th>Note</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($items as $index => $item): ?>
                        <tr>
                            <td><?php if (!empty($item['image'])): ?><img src="../<?php echo e($item['image']); ?>" alt=""><?php else: ?><span class="admin-thumb-none">None</span><?php endif; ?></td>
                            <td><?php echo e($item['name']); ?></td>
                            <td><?php echo e($item['class']); ?></td>
                            <td><?php echo e($item['score']); ?></td>
                            <td><?php echo e($item['note']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="toppers.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="toppers.php" onsubmit="return confirm('Delete this topper?');">
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
