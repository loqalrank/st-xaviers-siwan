<?php
$siteConfig = include __DIR__ . '/includes/site-config.php';
$faq        = isset($siteConfig['faq']) ? $siteConfig['faq'] : ['categories' => [], 'items' => []];
$fCategories = isset($faq['categories']) ? $faq['categories'] : [];
$fItems      = isset($faq['items']) ? $faq['items'] : [];

$fGrouped = [];
foreach ($fCategories as $key => $label) {
    $fGrouped[$key] = [];
}
foreach ($fItems as $fItem) {
    $cat = isset($fItem['category']) ? $fItem['category'] : '';
    if (isset($fGrouped[$cat])) {
        $fGrouped[$cat][] = $fItem;
    }
}

$fActive = [];
foreach ($fCategories as $catKey => $catLabel) {
    if (!empty($fGrouped[$catKey])) {
        $fActive[$catKey] = $catLabel;
    }
}

$seoPage='faq.php'; $seoBreadcrumbs=['Home'=>'index.php','FAQs'=>'faq.php']; include "header.php"; ?>
<section class="page-hero"><div class="container position-relative"><div class="kicker">Helpful information</div><h1 class="section-title" style="max-width:780px">Frequently asked questions.</h1><p class="lead-copy mb-0">Quick answers to common questions. Please contact the school office to confirm current details.</p><nav class="mt-3" aria-label="breadcrumb"><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.php">Home</a></li><li class="breadcrumb-item active" aria-current="page">FAQs</li></ol></nav></div></section>
<section class="section soft-bg"><div class="container">

<ul class="nav nav-pills flex-wrap gap-2 justify-content-center mb-5" id="faqTabs" role="tablist">
<?php $firstTab = true; foreach ($fActive as $catKey => $catLabel): ?>
  <li class="nav-item" role="presentation">
    <button class="filter-btn<?php echo $firstTab ? ' active' : ''; ?>" id="tab-<?php echo htmlspecialchars($catKey, ENT_QUOTES, 'UTF-8'); ?>" data-bs-toggle="pill" data-bs-target="#tab-pane-<?php echo htmlspecialchars($catKey, ENT_QUOTES, 'UTF-8'); ?>" type="button" role="tab"><?php echo htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8'); ?></button>
  </li>
<?php $firstTab = false; endforeach; ?>
</ul>

<div class="tab-content" id="faqTabsContent">
<?php $firstTab = true; $qNum = 0; foreach ($fActive as $catKey => $catLabel): ?>
  <div class="tab-pane fade<?php echo $firstTab ? ' show active' : ''; ?>" id="tab-pane-<?php echo htmlspecialchars($catKey, ENT_QUOTES, 'UTF-8'); ?>" role="tabpanel">
    <div class="accordion mx-auto" style="max-width:850px" id="faq-<?php echo htmlspecialchars($catKey, ENT_QUOTES, 'UTF-8'); ?>">
<?php $firstItem = true; foreach ($fGrouped[$catKey] as $fItem): $qNum++; $qId = 'faq' . $qNum; ?>
      <div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button<?php echo $firstItem ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $qId; ?>" aria-expanded="<?php echo $firstItem ? 'true' : 'false'; ?>" aria-controls="<?php echo $qId; ?>">Q<?php echo $qNum; ?>. <?php echo htmlspecialchars(isset($fItem['question']) ? $fItem['question'] : '', ENT_QUOTES, 'UTF-8'); ?></button></h2><div id="<?php echo $qId; ?>" class="accordion-collapse collapse<?php echo $firstItem ? ' show' : ''; ?>" data-bs-parent="#faq-<?php echo htmlspecialchars($catKey, ENT_QUOTES, 'UTF-8'); ?>"><div class="accordion-body text-muted-custom"><?php if (!empty($fItem['answer_html'])) { echo $fItem['answer_html']; } else { echo nl2br(htmlspecialchars(isset($fItem['answer']) ? $fItem['answer'] : '', ENT_QUOTES, 'UTF-8')); } ?></div></div></div>
<?php $firstItem = false; endforeach; ?>
    </div>
  </div>
<?php $firstTab = false; endforeach; ?>
</div>

</div></section>
<section class="section-sm"><div class="container"><div class="blue-panel p-4 p-lg-5"><div class="row align-items-center g-4 position-relative" style="z-index:1"><div class="col-lg-8"><div class="kicker text-warning">Still have questions?</div><h2 class="section-title">We're happy to help.</h2><p class="mb-0">Send your question to the school using our contact page.</p></div>    <div class="col-lg-4 text-lg-end"><a href="contact.php" class="btn btn-light-pill">Contact the School <i class="bi bi-arrow-right ms-1"></i></a></div></div></div></div></section>
<?php
$faqQuestions = [];
foreach ($fItems as $fItem) {
    $answer = isset($fItem['answer']) ? $fItem['answer'] : '';
    if ($answer === '' && !empty($fItem['answer_html'])) {
        $answer = trim(strip_tags(str_replace('<br>', ' ', $fItem['answer_html'])));
    }
    $faqQuestions[] = [
        'question' => isset($fItem['question']) ? $fItem['question'] : '',
        'answer'   => $answer,
    ];
}
seo_schema(schema_faq($faqQuestions));
?>
<?php include "footer.php"; ?>
