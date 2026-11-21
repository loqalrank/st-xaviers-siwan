<?php
require_once __DIR__ . '/includes/seo-helpers.php';
$siteConfig = include __DIR__ . '/includes/site-config.php';
$blogPosts  = isset($siteConfig['blog']['posts']) ? $siteConfig['blog']['posts'] : [];

$requestedSlug = '';
if (isset($_GET['slug']) && $_GET['slug'] !== '') {
    $requestedSlug = (string) $_GET['slug'];
} elseif (!empty($_SERVER['PATH_INFO'])) {
    $requestedSlug = trim((string) $_SERVER['PATH_INFO'], '/');
    $requestedSlug = urldecode($requestedSlug);
}
$post = null;
foreach ($blogPosts as $candidate) {
    $candidateSlug = seo_slugify(isset($candidate['title']) ? $candidate['title'] : '');
    if ($requestedSlug !== '' && $candidateSlug === $requestedSlug) {
        $post = $candidate;
        break;
    }
}
if ($post === null && $blogPosts) {
    $post = $blogPosts[0];
}

if ($post === null) {
    http_response_code(404);
    $pageTitle = 'Article Not Found | St. Xavier High School Siwan';
    $pageDesc  = 'The requested article could not be found.';
    $seoPage   = 'blog-detail.php';
    include "header.php";
    echo '<section class="section"><div class="container text-center"><h1 class="section-title">Article not found</h1><p class="lead-copy">This story is no longer available.</p><a href="blog.php" class="btn btn-primary mt-3">Back to Blog</a></div></section>';
    include "footer.php";
    exit;
}

$postTitle   = isset($post['title']) ? $post['title'] : '';
$postMetaTtl = !empty($post['meta_title']) ? $post['meta_title'] : $postTitle;
$postMetaDsc = !empty($post['meta_description']) ? $post['meta_description'] : (isset($post['excerpt']) ? $post['excerpt'] : '');
$postCategory = isset($post['category']) ? $post['category'] : '';
$postDate     = isset($post['date']) ? $post['date'] : '';
$postReadTime = isset($post['read_time']) ? $post['read_time'] : '';
$postImage    = isset($post['image']) ? $post['image'] : 'assets/images/local/school-campus.jpg';
$postImageAlt = !empty($post['image_alt']) ? $post['image_alt'] : $postTitle;
$postExcerpt  = isset($post['excerpt']) ? $post['excerpt'] : '';
$postTags     = isset($post['tags']) && is_array($post['tags']) ? $post['tags'] : [];
$postContent  = isset($post['content']) ? $post['content'] : '';
$postSlug     = seo_slugify($postTitle);
$postUrl      = seo_canonical('blog-detail.php') . ($postSlug !== '' ? '/' . $postSlug : '');

$pageTitle = $postMetaTtl;
$pageDesc  = $postMetaDsc;
$seoPage   = 'blog-detail.php' . ($postSlug !== '' ? '/' . $postSlug : '');
$seoImage  = $postImage;
$seoBreadcrumbs = ['Home' => 'index.php', 'Blog' => 'blog.php', 'Article' => 'blog-detail.php'];
include "header.php";

seo_schema(schema_article($postTitle, $postMetaDsc, $postUrl, seo_image($postImage), SITE_NAME, SITE_NAME));
?>

<section class="page-hero"><div class="container position-relative"><div class="kicker"><?php echo htmlspecialchars($postCategory, ENT_QUOTES, 'UTF-8'); ?></div><h1 class="section-title" style="max-width:900px"><?php echo htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8'); ?></h1><p class="lead-copy mb-0"><?php echo htmlspecialchars($postExcerpt, ENT_QUOTES, 'UTF-8'); ?></p><nav class="mt-3"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item"><a href="blog.php">Blog</a></li><li class="breadcrumb-item active">Article</li></ol></nav></div></section>
<article class="section"><div class="container">
<div class="row g-5">
<div class="col-lg-8">
<img src="<?php echo htmlspecialchars($postImage, ENT_QUOTES, 'UTF-8'); ?>" class="w-100 rounded-4 mb-4" style="max-height:470px;object-fit:cover" alt="<?php echo htmlspecialchars($postImageAlt, ENT_QUOTES, 'UTF-8'); ?>" width="900" height="470" loading="lazy">
<div class="d-flex flex-wrap gap-3 small text-muted-custom mb-4"><?php if ($postCategory !== ''): ?><span><i class="bi bi-journal-text me-1"></i> <?php echo htmlspecialchars($postCategory, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?><?php if ($postDate !== ''): ?><span><i class="bi bi-calendar3 me-1"></i> <?php echo htmlspecialchars($postDate, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?><?php if ($postReadTime !== ''): ?><span><i class="bi bi-clock me-1"></i> <?php echo htmlspecialchars($postReadTime, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?></div>

<?php echo $postContent; ?>

<div class="p-4 rounded-4 mt-4" style="background:var(--sky)"><h3 class="h5">Stay connected with St. Xavier's</h3><p class="text-muted-custom mb-3">For school updates and admission information, get in touch with the school team.</p><a href="contact.php" class="btn btn-primary">Contact the School <i class="bi bi-arrow-right ms-1"></i></a></div>
<div class="mt-5"><a href="blog.php" class="fw-bold text-primary"><i class="bi bi-arrow-left me-2"></i>Back to all stories</a></div>
</div>

<aside class="col-lg-4">
<div class="blog-sidebar">
<div class="ad-card">
<span class="ad-label">Admissions Open</span>
<div class="ad-icon"><i class="bi bi-mortarboard-fill"></i></div>
<h3>Give Your Child a Strong Foundation</h3>
<p>CBSE education from Nursery to Class 12 (10+2). Explore admissions, facilities and learning at St. Xavier's High School, Siwan.</p>
<a href="admissions.php" class="btn btn-light text-primary fw-bold w-100">Enquire Now <i class="bi bi-arrow-right ms-1"></i></a>
</div>
<?php if ($postTags): ?>
<div class="sidebar-box">
<h3>Tags</h3>
<div class="sidebar-tags">
<?php foreach ($postTags as $tagLabel): ?>
<span class="blog-tag"><?php echo htmlspecialchars($tagLabel, ENT_QUOTES, 'UTF-8'); ?></span>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</div>
</aside>
</div>
</div></article>
<?php include "footer.php"; ?>
