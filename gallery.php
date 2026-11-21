<?php
$siteConfig = include __DIR__ . '/includes/site-config.php';
$gallery    = isset($siteConfig['gallery']) ? $siteConfig['gallery'] : ['categories' => [], 'items' => []];
$gCategories = isset($gallery['categories']) ? $gallery['categories'] : [];
$gItems      = isset($gallery['items']) ? $gallery['items'] : [];

$gCounts = [];
foreach ($gItems as $gItem) {
    $gCat = isset($gItem['category']) ? $gItem['category'] : '';
    if (!isset($gCounts[$gCat])) {
        $gCounts[$gCat] = 0;
    }
    $gCounts[$gCat]++;
}
$gActive = [];
foreach ($gCategories as $gKey => $gLabel) {
    if (!empty($gCounts[$gKey])) {
        $gActive[$gKey] = $gLabel;
    }
}

$seoPage='gallery.php'; $seoBreadcrumbs=['Home'=>'index.php','Gallery'=>'gallery.php']; include "header.php"; ?>
<section class="page-hero"><div class="container position-relative"><div class="kicker">School Gallery</div><h1 class="section-title" style="max-width:780px">Life at St. Xavier's</h1><p class="lead-copy mb-0">Every school day brings new opportunities to learn, participate and create memories. Explore photographs of our campus, learning environment, student activities and special moments.</p><nav class="mt-3" aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active" aria-current="page">Gallery</li></ol></nav></div></section>
<section class="section"><div class="container"><div class="d-flex flex-wrap gap-2 justify-content-center mb-5"><button class="filter-btn active" data-gallery-filter="all">All moments</button><?php foreach ($gActive as $key => $label): ?><button class="filter-btn" data-gallery-filter="<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></button><?php endforeach; ?></div><div class="row g-3">
<?php foreach ($gItems as $item):
    $cat  = isset($item['category']) ? $item['category'] : '';
    $img  = isset($item['image']) ? $item['image'] : '';
    $alt  = isset($item['alt']) ? $item['alt'] : '';
?>
<div class="col-6 col-lg-4" data-gallery-item="<?php echo htmlspecialchars($cat, ENT_QUOTES, 'UTF-8'); ?>"><img class="gallery-img" src="<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>" width="400" height="300" loading="lazy"></div>
<?php endforeach; ?>
</div></section>
<?php include "footer.php"; ?>
