<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config     = admin_config();
$items      = isset($config['faq']['items']) && is_array($config['faq']['items']) ? $config['faq']['items'] : [];
$categories = isset($config['faq']['categories']) && is_array($config['faq']['categories']) ? $config['faq']['categories'] : [];
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
            if (content_store_save_section('faq', $items)) {
                admin_flash('success', 'FAQ deleted.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('faq.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $item = [
            'category'    => (string) ($_POST['category'] ?? ''),
            'question'    => trim((string) ($_POST['question'] ?? '')),
            'answer'      => trim((string) ($_POST['answer'] ?? '')),
            'answer_html' => trim((string) ($_POST['answer_html'] ?? '')),
        ];

        if (!isset($categories[$item['category']])) {
            $error = 'Choose a valid category.';
        } elseif ($item['question'] === '') {
            $error = 'Question is required.';
        } elseif ($item['answer'] === '') {
            $error = 'Plain-text answer is required (used for search engines).';
        } elseif ($editId >= 0 && !isset($items[$editId])) {
            $error = 'FAQ not found.';
        }

        if ($error === '') {
            if ($item['answer_html'] === '') {
                unset($item['answer_html']);
            }
            if ($editId >= 0) {
                $items[$editId] = $item;
            } else {
                $items[] = $item;
            }

            if (content_store_save_section('faq', $items)) {
                admin_flash('success', 'FAQ saved.');
                admin_redirect('faq.php');
            }
            $error = 'Could not save the FAQ. Check that data/ is writable.';
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
                admin_flash('error', 'FAQ not found.');
                admin_redirect('faq.php');
            }
            $form = $items[$id];
            if (!isset($form['answer_html'])) {
                $form['answer_html'] = '';
            }
        } else {
            reset($categories);
            $form = ['category' => (string) key($categories), 'question' => '', 'answer' => '', 'answer_html' => ''];
        }
    }

    admin_header($action === 'edit' ? 'Edit FAQ' : 'New FAQ', 'faq');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="faq.php" class="admin-form">
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
                <label for="question">Question</label>
                <input type="text" id="question" name="question" value="<?php echo e($form['question']); ?>" required>
            </div>
            <div class="admin-field">
                <label for="answer">Answer (plain text)</label>
                <textarea id="answer" name="answer" required><?php echo e($form['answer']); ?></textarea>
                <div class="admin-hint">Used in the FAQ schema shown to search engines.</div>
            </div>
            <div class="admin-field">
                <label for="answer_html">Answer HTML (optional)</label>
                <textarea id="answer_html" name="answer_html" class="code"><?php echo e($form['answer_html']); ?></textarea>
                <div class="admin-hint">Shown on the FAQ page when provided. Leave empty to display the plain answer.</div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save FAQ</button>
                <a class="admin-btn admin-btn-light" href="faq.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

admin_header('FAQs', 'faq');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="faq.php?action=new">New FAQ</a>
</div>
<div class="admin-card">
    <?php if (!$items): ?>
        <p>No FAQs yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Category</th><th>Question</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($items as $index => $item): ?>
                        <tr>
                            <td><?php echo e(isset($categories[$item['category']]) ? $categories[$item['category']] : $item['category']); ?></td>
                            <td><?php echo e($item['question']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="faq.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="faq.php" onsubmit="return confirm('Delete this FAQ?');">
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
