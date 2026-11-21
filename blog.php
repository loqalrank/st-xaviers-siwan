<?php
require_once __DIR__ . '/includes/seo-helpers.php';
$siteConfig = include __DIR__ . '/includes/site-config.php';
$blogPosts  = isset($siteConfig['blog']['posts']) ? $siteConfig['blog']['posts'] : [];

$seoPage   = 'blog.php';
$seoBreadcrumbs = ['Home' => 'index.php', 'Blog' => 'blog.php'];
include "header.php";
?>

<section class="page-hero"><div class="container position-relative"><div class="kicker">News, stories & updates</div><h1 class="section-title" style="max-width:780px">News, Updates and Insights</h1><p class="lead-copy mb-0">School news, results and updates from St. Xavier High School, Siwan.</p><nav class="mt-3" aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active" aria-current="page">Blog</li></ol></nav></div></section>
<section class="section"><div class="container">
<div class="row align-items-end mb-4"><div class="col"><div class="kicker">From our school desk</div><h2 class="section-title mb-0">Latest stories</h2></div><div class="col-auto text-muted-custom small">News &middot; Results &middot; Updates</div></div>
<div class="row g-4">
<?php foreach ($blogPosts as $post):
    $title   = isset($post['title']) ? $post['title'] : '';
    $slug    = seo_slugify($title);
    $excerpt = isset($post['excerpt']) ? $post['excerpt'] : '';
    $image   = isset($post['image']) ? $post['image'] : 'assets/images/local/school-campus.jpg';
    $alt     = isset($post['image_alt']) ? $post['image_alt'] : $title;
    $tags    = isset($post['tags']) && is_array($post['tags']) ? $post['tags'] : [];
    $tag     = $tags ? $tags[0] : (isset($post['category']) ? $post['category'] : '');
    $link    = 'blog-detail.php/' . rawurlencode($slug);
?>
<div class="col-md-6 col-lg-4"><article class="program-card h-100"><img src="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>" width="400" height="300" loading="lazy"><div class="program-body"><h3 class="h4"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h3><p><?php echo htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8'); ?></p><?php if ($tag !== ''): ?><span class="blog-tag"><?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?><a class="fw-bold text-primary d-block mt-3" href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>">Read story <i class="bi bi-arrow-right"></i></a></div></article></div>
<?php endforeach; ?>
</div>
</section>
<?php include "footer.php"; ?>
