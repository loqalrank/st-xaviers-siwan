<?php $seoPage='mandatory-disclosure.php'; $seoBreadcrumbs=['Home'=>'index.php','Mandatory Disclosure'=>'mandatory-disclosure.php']; include "header.php"; ?>
<?php
$mdDocuments = isset($siteConfig['mandatory_disclosure']['documents']) && is_array($siteConfig['mandatory_disclosure']['documents'])
    ? $siteConfig['mandatory_disclosure']['documents']
    : [];

$mdGroups = [];
foreach ($mdDocuments as $mdDoc) {
    $mdSection = isset($mdDoc['section']) && trim((string) $mdDoc['section']) !== '' ? trim((string) $mdDoc['section']) : 'Documents';
    $mdGroups[$mdSection][] = $mdDoc;
}
?>
<section class="page-hero">
    <div class="container position-relative">
        <div class="kicker">Public Mandatory Disclosure</div>
        <h1 class="section-title" style="max-width:780px">Mandatory Public Disclosure</h1>
        <p class="lead-copy mb-0">St. Xavier's High School is committed to maintaining transparency and making relevant school information and documents accessible to parents and visitors.</p>
        <nav class="mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Public Mandatory Disclosure</li>
            </ol>
        </nav>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title text-center mb-3">Public Mandatory Disclosure Documents</h2>
        <p class="lead-copy text-center mx-auto mb-5">Review the available school documents below. Please check with the school for the latest approved information.</p>

<?php if (!$mdGroups): ?>
        <p class="text-center">No documents are available right now. Please contact the school office.</p>
<?php else: ?>
<?php $mdFirst = true; foreach ($mdGroups as $mdSection => $mdItems): ?>
        <h3 class="h4 <?php echo $mdFirst ? 'mt-2' : 'mt-5'; ?> mb-3"><?php echo htmlspecialchars($mdSection, ENT_QUOTES, 'UTF-8'); ?></h3>
        <div class="row g-4">
<?php foreach ($mdItems as $mdItem): ?>
            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100"><h3 class="h5 mb-2"><?php echo htmlspecialchars(isset($mdItem['title']) ? $mdItem['title'] : '', ENT_QUOTES, 'UTF-8'); ?></h3><a class="btn btn-outline-primary w-100" href="<?php echo htmlspecialchars(isset($mdItem['file']) ? $mdItem['file'] : '#', ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">Open PDF <i class="bi bi-arrow-up-right ms-1"></i></a></div>
            </div>
<?php endforeach; ?>
        </div>
<?php $mdFirst = false; endforeach; ?>
<?php endif; ?>

    </div>
</section>
<?php include "footer.php"; ?>
