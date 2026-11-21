<?php
require_once __DIR__ . '/includes/seo-helpers.php';

$seoPage    = isset($seoPage) ? $seoPage : 'index.php';
$siteConfig = include __DIR__ . '/includes/site-config.php';
$configPage = isset($siteConfig['pages'][$seoPage]) ? $siteConfig['pages'][$seoPage] : [];

$pageTitle = !empty($pageTitle) ? $pageTitle : (isset($configPage['title']) ? $configPage['title'] : 'St. Xavier\'s High School, Siwan');
$pageDesc  = !empty($pageDesc) ? $pageDesc : (isset($configPage['description']) ? $configPage['description'] : '');
$seoImage  = !empty($seoImage) ? $seoImage : (isset($configPage['image']) ? $configPage['image'] : '');
$preloadImage = $seoImage ?: 'assets/images/local/campus.jpg';
$seoBreadcrumbs = isset($seoBreadcrumbs) ? $seoBreadcrumbs : [];

$__scriptPath = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/index.php';
$__baseDir    = str_replace('\\', '/', dirname(str_replace('\\', '/', $__scriptPath)));
$baseHref     = rtrim($__baseDir, '/') . '/';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo seo_escape($baseHref); ?>">
    <title><?php echo seo_escape($pageTitle); ?></title>
    <meta name="description" content="<?php echo seo_escape($pageDesc); ?>">
    <link href="assets/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/vendor/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/school-logo.png">
    <link rel="stylesheet" href="assets/css/vendor/fontawesome.min.css">

    <link rel="preload" as="image" href="assets/images/school-logo.png" fetchpriority="high">
    <link rel="preload" as="image" href="<?php echo seo_escape($preloadImage); ?>" fetchpriority="high">

    <?php seo_head_meta($seoPage, $pageTitle, $pageDesc, $seoImage, 'website', $seoBreadcrumbs); ?>
</head>

<body>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YZQYMSPG4D"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-YZQYMSPG4D');
    </script>
    <div class="top-strip">
        <div class="container d-flex flex-wrap justify-content-between gap-2 align-items-center"><span><i class="bi bi-geo-alt me-1"></i> <a href="https://maps.app.goo.gl/hFFeWm5WSbaux7jd6" target="_blank" rel="noopener noreferrer" aria-label="Location" title="Location">Siwan, Bihar, India</a></span>
            <div class="top-right d-flex align-items-center gap-2"><span class="top-phone"><i class="bi bi-telephone me-1"></i>
                <a href="tel:+91-8000800362" class="mr-2"style="font-size: 20px;">+91-8000800362</a>
                </span>
                <div class="social-links" aria-label="Social media links"><a href="https://www.facebook.com/p/St-Xaviers-High-School-Siwan-61579324704561/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a><a href="https://www.instagram.com/stxavierssiwan/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" title="Instagram"><i class="fab fa-instagram"></i></a><a href="https://www.youtube.com/@St.xavierssiwan" target="_blank" rel="noopener noreferrer" aria-label="YouTube" title="YouTube"><i class="fab fa-youtube"></i></a></div>
            </div>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-xl sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img class="school-logo" src="assets/images/school-logo.png" alt="St. Xavier's High School logo"><span class="brand-towne">St. Xavier's High School</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="admissions.php">Admissions</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Our School</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="academics.php">Academics</a></li>
                            <li><a class="dropdown-item" href="facilities.php">Facilities</a></li>
                            <li><a class="dropdown-item" href="messages.php">Leadership Messages</a></li>
                            <li><a class="dropdown-item" href="faq.php">FAQs</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item nav-cta ms-lg-2"><a class="btn btn-primary" href="admissions.php">Enquire Now <i class="bi bi-arrow-right ms-1"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // Organization + Website structured data (consistent @id across all pages)
    seo_schema(schema_organization(SITE_URL, SITE_LOGO, [SITE_PHONE_1, SITE_PHONE_2, SITE_PHONE_3], SITE_EMAIL));
    seo_schema(schema_website(SITE_URL, SITE_NAME));
    ?>
