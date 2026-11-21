<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config = admin_config();
$docs   = isset($config['mandatory_disclosure']['documents']) && is_array($config['mandatory_disclosure']['documents'])
    ? $config['mandatory_disclosure']['documents']
    : [];
$action = isset($_GET['action']) ? (string) $_GET['action'] : 'list';
$id     = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$error  = '';
$form   = null;

$sections = [];
foreach ($docs as $doc) {
    $name = isset($doc['section']) ? trim((string) $doc['section']) : '';
    if ($name !== '' && !in_array($name, $sections, true)) {
        $sections[] = $name;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'delete') {
        $deleteId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        if (isset($docs[$deleteId])) {
            array_splice($docs, $deleteId, 1);
            if (content_store_save_section('disclosure_docs', $docs)) {
                admin_flash('success', 'Document removed.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('disclosure.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $doc = [
            'section' => trim((string) ($_POST['section'] ?? '')),
            'title'   => trim((string) ($_POST['title'] ?? '')),
            'file'    => trim((string) ($_POST['file'] ?? '')),
        ];

        try {
            $doc['file'] = admin_handle_pdf_upload('pdf_file', $doc['file']);
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }

        if ($error === '') {
            if ($doc['title'] === '') {
                $error = 'Document title is required.';
            } elseif ($doc['file'] === '') {
                $error = 'Upload a PDF or enter a PDF path/link.';
            } elseif (!preg_match('~^(https?://|/|assets/|\.\.?)~i', $doc['file'])) {
                $error = 'Enter a full URL or a path starting with assets/ or /.';
            }
        }

        if ($error === '') {
            if ($doc['section'] === '') {
                $doc['section'] = 'Documents';
            }
            if ($editId >= 0 && isset($docs[$editId])) {
                $docs[$editId] = $doc;
            } else {
                $docs[] = $doc;
            }

            if (content_store_save_section('disclosure_docs', $docs)) {
                admin_flash('success', 'Document saved.');
                admin_redirect('disclosure.php');
            }
            $error = 'Could not save the document. Check that data/ is writable.';
        }

        $form = $doc;
        $id = $editId;
        $action = $editId >= 0 ? 'edit' : 'new';
    }
}

if ($action === 'new' || $action === 'edit') {
    if ($form === null) {
        if ($action === 'edit') {
            if (!isset($docs[$id])) {
                admin_flash('error', 'Document not found.');
                admin_redirect('disclosure.php');
            }
            $form = $docs[$id];
        } else {
            $form = ['section' => $sections ? $sections[0] : 'Extension', 'title' => '', 'file' => ''];
        }
    }

    admin_header($action === 'edit' ? 'Edit document' : 'Add document', 'disclosure');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="disclosure.php" enctype="multipart/form-data" class="admin-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="op" value="save">
            <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

            <div class="admin-field">
                <label for="section">Section heading</label>
                <input type="text" id="section" name="section" value="<?php echo e($form['section']); ?>" list="disclosureSections" placeholder="Extension">
                <datalist id="disclosureSections">
                    <?php foreach ($sections as $sectionName): ?>
                        <option value="<?php echo e($sectionName); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
                <div class="admin-hint">Documents with the same heading are grouped together on the page.</div>
            </div>
            <div class="admin-field">
                <label for="title">Document title</label>
                <input type="text" id="title" name="title" value="<?php echo e($form['title']); ?>" required>
            </div>
            <div class="admin-field">
                <label for="pdf_file">Upload PDF</label>
                <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf,.pdf">
                <div class="admin-hint">PDF only, maximum 10 MB. Uploaded files go to assets/documents/.</div>
            </div>
            <div class="admin-field">
                <label for="file">Or PDF path / link</label>
                <input type="text" id="file" name="file" value="<?php echo e($form['file']); ?>" placeholder="assets/documents/fee-schedule.pdf or https://...">
                <div class="admin-hint">Accepts a website path or a full external URL. Links always open in a new tab.</div>
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save document</button>
                <a class="admin-btn admin-btn-light" href="disclosure.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

admin_header('Mandatory disclosure', 'disclosure');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="disclosure.php?action=new">Add document</a>
    <a class="admin-btn admin-btn-light" href="../mandatory-disclosure.php" target="_blank" rel="noopener">Preview page</a>
</div>
<div class="admin-card">
    <?php if (!$docs): ?>
        <p>No documents yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Section</th><th>Title</th><th>File</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($docs as $index => $doc): ?>
                        <tr>
                            <td><?php echo e($doc['section']); ?></td>
                            <td><?php echo e($doc['title']); ?></td>
                            <td style="max-width:280px;word-break:break-all"><?php echo e($doc['file']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="disclosure.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="disclosure.php" onsubmit="return confirm('Delete this document?');">
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
