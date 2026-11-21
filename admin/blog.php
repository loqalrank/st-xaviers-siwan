<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/layout.php';

admin_require_login();

$config = admin_config();
$posts  = isset($config['blog']['posts']) && is_array($config['blog']['posts']) ? $config['blog']['posts'] : [];
$action = isset($_GET['action']) ? (string) $_GET['action'] : 'list';
$id     = isset($_GET['id']) ? (int) $_GET['id'] : -1;
$error  = '';
$form   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $op = isset($_POST['op']) ? (string) $_POST['op'] : '';

    if ($op === 'delete') {
        $deleteId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        if (isset($posts[$deleteId])) {
            array_splice($posts, $deleteId, 1);
            if (content_store_save_section('blog', $posts)) {
                admin_flash('success', 'Blog post deleted.');
            } else {
                admin_flash('error', 'Could not save changes. Check that data/ is writable.');
            }
        }
        admin_redirect('blog.php');
    }

    if ($op === 'save') {
        $editId = isset($_POST['id']) ? (int) $_POST['id'] : -1;
        $post = [
            'title'            => trim((string) ($_POST['title'] ?? '')),
            'meta_title'       => trim((string) ($_POST['meta_title'] ?? '')),
            'meta_description' => trim((string) ($_POST['meta_description'] ?? '')),
            'category'         => trim((string) ($_POST['category'] ?? '')),
            'date'             => trim((string) ($_POST['date'] ?? '')),
            'read_time'        => trim((string) ($_POST['read_time'] ?? '')),
            'image'            => trim((string) ($_POST['image_path'] ?? '')),
            'image_alt'        => trim((string) ($_POST['image_alt'] ?? '')),
            'excerpt'          => trim((string) ($_POST['excerpt'] ?? '')),
            'tags'             => array_values(array_filter(array_map('trim', explode(',', (string) ($_POST['tags'] ?? ''))), 'strlen')),
            'content'          => (string) ($_POST['content'] ?? ''),
        ];

        try {
            $post['image'] = admin_handle_upload('image_file', $post['image']);
        } catch (RuntimeException $ex) {
            $error = $ex->getMessage();
        }

        if ($error === '') {
            if ($post['title'] === '') {
                $error = 'Title is required.';
            } elseif ($post['date'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $post['date'])) {
                $error = 'Date must use the YYYY-MM-DD format.';
            } elseif (trim(strip_tags($post['content'])) === '') {
                $error = 'Post content is required.';
            }
        }

        if ($error === '') {
            if ($post['date'] === '') {
                $post['date'] = date('Y-m-d');
            }
            if ($post['image'] === '') {
                $post['image'] = 'assets/images/local/school-campus.jpg';
            }
            if ($post['image_alt'] === '') {
                $post['image_alt'] = $post['title'];
            }
            if ($post['meta_title'] === '') {
                $post['meta_title'] = $post['title'];
            }
            if ($post['excerpt'] === '') {
                $post['excerpt'] = mb_substr(trim(strip_tags($post['content'])), 0, 180) . '...';
            }

            if ($editId >= 0 && isset($posts[$editId])) {
                $posts[$editId] = $post;
            } else {
                array_unshift($posts, $post);
            }

            if (content_store_save_section('blog', $posts)) {
                admin_flash('success', 'Blog post saved.');
                admin_redirect('blog.php');
            }
            $error = 'Could not save the post. Check that data/ is writable.';
        }

        $form = $post;
        $id = $editId;
        $action = $editId >= 0 ? 'edit' : 'new';
    }
}

if ($action === 'new' || $action === 'edit') {
    if ($form === null) {
        if ($action === 'edit') {
            if (!isset($posts[$id])) {
                admin_flash('error', 'Blog post not found.');
                admin_redirect('blog.php');
            }
            $form = $posts[$id];
        } else {
            $form = [
                'title' => '', 'meta_title' => '', 'meta_description' => '', 'category' => 'Education & School News',
                'date' => date('Y-m-d'), 'read_time' => '3 min read', 'image' => '', 'image_alt' => '',
                'excerpt' => '', 'tags' => [], 'content' => '',
            ];
        }
    }

    admin_header($action === 'edit' ? 'Edit blog post' : 'New blog post', 'blog');
    ?>
    <?php if ($error !== ''): ?>
        <div class="admin-alert is-error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <div class="admin-card">
        <form method="post" action="blog.php" enctype="multipart/form-data" class="admin-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="op" value="save">
            <input type="hidden" name="id" value="<?php echo (int) $id; ?>">

            <div class="admin-field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo e($form['title']); ?>" required>
                <div class="admin-hint">Changing the title also changes the public article URL.</div>
            </div>
            <div class="admin-field">
                <label for="meta_title">Meta title</label>
                <input type="text" id="meta_title" name="meta_title" value="<?php echo e($form['meta_title']); ?>">
            </div>
            <div class="admin-field">
                <label for="meta_description">Meta description</label>
                <textarea id="meta_description" name="meta_description"><?php echo e($form['meta_description']); ?></textarea>
            </div>
            <div class="admin-field">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="<?php echo e($form['category']); ?>">
            </div>
            <div class="admin-field">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo e($form['date']); ?>">
            </div>
            <div class="admin-field">
                <label for="read_time">Read time</label>
                <input type="text" id="read_time" name="read_time" value="<?php echo e($form['read_time']); ?>" placeholder="3 min read">
            </div>
            <div class="admin-field">
                <label for="image_path">Image path</label>
                <input type="text" id="image_path" name="image_path" value="<?php echo e($form['image']); ?>" placeholder="assets/images/local/school-campus.jpg">
                <div class="admin-hint">Use an existing path or upload a new file below.</div>
            </div>
            <div class="admin-field">
                <label for="image_file">Replace image</label>
                <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
            </div>
            <div class="admin-field">
                <label for="image_alt">Image alt text</label>
                <input type="text" id="image_alt" name="image_alt" value="<?php echo e($form['image_alt']); ?>">
            </div>
            <div class="admin-field">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt"><?php echo e($form['excerpt']); ?></textarea>
            </div>
            <div class="admin-field">
                <label for="tags">Tags</label>
                <input type="text" id="tags" name="tags" value="<?php echo e(implode(', ', $form['tags'])); ?>">
                <div class="admin-hint">Comma-separated.</div>
            </div>
            <div class="admin-field">
                <label for="content">Content (HTML allowed)</label>
                <textarea id="content" name="content" class="code"><?php echo e($form['content']); ?></textarea>
            </div>

            <div class="admin-actions">
                <button type="submit" class="admin-btn">Save post</button>
                <a class="admin-btn admin-btn-light" href="blog.php">Cancel</a>
            </div>
        </form>
    </div>
    <?php
    admin_footer();
    exit;
}

admin_header('Blog posts', 'blog');
?>
<div class="admin-actions" style="margin-bottom:16px">
    <a class="admin-btn" href="blog.php?action=new">New blog post</a>
</div>
<div class="admin-card">
    <?php if (!$posts): ?>
        <p>No blog posts yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead><tr><th>Image</th><th>Title</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php foreach ($posts as $index => $post): ?>
                        <tr>
                            <td><?php if (!empty($post['image'])): ?><img src="../<?php echo e($post['image']); ?>" alt=""><?php else: ?><span class="admin-thumb-none">None</span><?php endif; ?></td>
                            <td><?php echo e($post['title']); ?></td>
                            <td><?php echo e($post['date']); ?></td>
                            <td>
                                <div class="admin-actions">
                                    <a class="admin-btn admin-btn-sm admin-btn-light" href="blog.php?action=edit&amp;id=<?php echo (int) $index; ?>">Edit</a>
                                    <form method="post" action="blog.php" onsubmit="return confirm('Delete this post?');">
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
