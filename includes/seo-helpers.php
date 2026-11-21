<?php
/**
 * SEO helpers for St. Xavier's High School, Siwan
 * Reusable canonical URL, Open Graph, Twitter Card, and JSON-LD structured data.
 */

if (!defined('SITE_URL')) {
    define('SITE_URL', 'https://www.stxavierssiwan.com');
}
if (!defined('SITE_NAME')) {
    define('SITE_NAME', "St. Xavier's High School, Siwan");
}
if (!defined('SITE_LOGO')) {
    define('SITE_LOGO', SITE_URL . '/assets/images/school-logo.png');
}
if (!defined('SITE_ADDRESS')) {
    define('SITE_ADDRESS', "St. Xavier's High School, Baishakhi, Siwan, Bihar");
}
if (!defined('SITE_ADDRESS_SHORT')) {
    define('SITE_ADDRESS_SHORT', "Baishakhi, Siwan, Bihar");
}
if (!defined('SITE_PHONE_1')) {
    define('SITE_PHONE_1', '+91-8000800362');
}
if (!defined('SITE_PHONE_2')) {
    define('SITE_PHONE_2', '+91-8000800364');
}
if (!defined('SITE_PHONE_3')) {
    define('SITE_PHONE_3', '+91-8000800368');
}
if (!defined('SITE_EMAIL')) {
    define('SITE_EMAIL', 'stxavierssiwan@gmail.com');
}

/**
 * Return canonical URL for a given page filename.
 */
function seo_canonical(string $page = 'index.php'): string
{
    return SITE_URL . '/' . ltrim($page, '/');
}

/**
 * Return absolute URL for an asset path, or default logo if none given.
 */
function seo_image(?string $image = null): string
{
    if ($image) {
        return SITE_URL . '/' . ltrim($image, '/');
    }
    return SITE_LOGO;
}

/**
 * Convert a title into a URL slug (used for blog article URLs).
 */
function seo_slugify(string $text): string
{
    $text = trim($text);
    $text = preg_replace("/['\x{2019}`]/u", '', $text);
    $text = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
    $text = trim((string) $text, '-');
    $text = strtolower($text);
    return $text !== '' ? $text : 'post';
}

/**
 * Escape a string for safe use inside HTML attribute / JSON-LD text.
 */
function seo_escape(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Output <meta> tags: canonical, Open Graph, Twitter Card.
 * Call from <head> after title/description are set.
 *
 * @param string $page      Page filename (e.g. about.php) for canonical URL
 * @param string $title     Page title (already escaped by caller)
 * @param string $desc      Page description (already escaped by caller)
 * @param string $image     Optional OG image path override
 * @param string $type      og:type (website or article)
 * @param array  $breadcrumbs Optional array of ['label' => 'url'] for BreadcrumbList schema
 */
function seo_head_meta(
    string $page = 'index.php',
    string $title = '',
    string $desc = '',
    string $image = '',
    string $type = 'website',
    array $breadcrumbs = []
): void {
    $canonical = seo_canonical($page);
    $ogImage = seo_image($image);
    $ogTitle = $title ?: SITE_NAME;
    $ogDesc = $desc ?: 'Discover St. Xavier\'s High School, Siwan, Bihar — academics, admissions, facilities and contact details.';
    $ogUrl = $canonical;

    echo "\n<!-- SEO Meta -->\n";
    echo '<link rel="canonical" href="' . seo_escape($canonical) . '">' . "\n";
    echo '<meta property="og:type" content="' . seo_escape($type) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . seo_escape(SITE_NAME) . '">' . "\n";
    echo '<meta property="og:title" content="' . seo_escape($ogTitle) . '">' . "\n";
    echo '<meta property="og:description" content="' . seo_escape($ogDesc) . '">' . "\n";
    echo '<meta property="og:url" content="' . seo_escape($ogUrl) . '">' . "\n";
    echo '<meta property="og:image" content="' . seo_escape($ogImage) . '">' . "\n";
    echo '<meta property="og:image:alt" content="' . seo_escape($ogTitle) . '">' . "\n";
    echo '<meta property="og:locale" content="en_IN">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:site" content="@stxavierssiwan">' . "\n";
    echo '<meta name="twitter:title" content="' . seo_escape($ogTitle) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . seo_escape($ogDesc) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . seo_escape($ogImage) . '">' . "\n";
    echo '<meta name="twitter:image:alt" content="' . seo_escape($ogTitle) . '">' . "\n";

    // BreadcrumbList JSON-LD
    if ($breadcrumbs) {
        $items = [];
        $position = 1;
        foreach ($breadcrumbs as $label => $url) {
            $url = (string) $url;
            if (!preg_match('#^https?://#i', $url)) {
                $url = SITE_URL . '/' . ltrim($url, '/');
            }
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $label,
                'item' => $url,
            ];
        }
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
        echo "\n<!-- Breadcrumb Structured Data -->\n";
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}

/**
 * Organization / School JSON-LD for homepage and about.
 */
function schema_organization(string $url = '', string $logo = '', array $phones = [], string $email = ''): string
{
    $sameAs = [
        'https://www.facebook.com/p/St-Xaviers-High-School-Siwan-61579324704561/',
        'https://www.instagram.com/stxavierssiwan/',
        'https://www.youtube.com/@St.xavierssiwan',
    ];

    $org = [
        '@context' => 'https://schema.org',
        '@type' => 'School',
        '@id' => (string) ($url ?: SITE_URL) . '#organization',
        'name' => SITE_NAME,
        'url' => $url ?: SITE_URL,
        'logo' => $logo ?: SITE_LOGO,
        'image' => $logo ?: SITE_LOGO,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Baishakhi',
            'addressLocality' => 'Siwan',
            'addressRegion' => 'Bihar',
            'addressCountry' => 'IN',
        ],
        'telephone' => $phones ? $phones : [SITE_PHONE_1, SITE_PHONE_2, SITE_PHONE_3],
        'email' => $email ?: SITE_EMAIL,
        'sameAs' => $sameAs,
    ];

    return json_encode($org, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

/**
 * WebSite JSON-LD with search action (site links search box eligibility).
 */
function schema_website(string $url = '', string $name = ''): string
{
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => (string) ($url ?: SITE_URL) . '#website',
        'name' => $name ?: SITE_NAME,
        'url' => $url ?: SITE_URL,
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

/**
 * ContactPoint JSON-LD.
 */
function schema_contact_point(string $phone = '', string $email = ''): string
{
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ContactPoint',
        'telephone' => $phone ?: SITE_PHONE_1,
        'contactType' => 'admissions',
        'email' => $email ?: SITE_EMAIL,
        'availableLanguage' => ['English', 'Hindi'],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

/**
 * FAQPage JSON-LD.
 * @param array $questions Each: ['question' => '...', 'answer' => '...']
 */
function schema_faq(array $questions): string
{
    $mainEntity = [];
    foreach ($questions as $q) {
        $mainEntity[] = [
            '@type' => 'Question',
            'name' => $q['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $q['answer'],
            ],
        ];
    }
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $mainEntity,
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

/**
 * Article JSON-LD for blog/article pages.
 */
function schema_article(
    string $headline,
    string $description,
    string $url,
    string $image = '',
    string $author = '',
    string $publisher = ''
): string {
    return json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        '@id' => $url . '#article',
        'headline' => $headline,
        'description' => $description,
        'image' => $image ?: SITE_LOGO,
        'author' => $author ? ['@type' => 'Organization', 'name' => $author] : ['@type' => 'Organization', 'name' => SITE_NAME],
        'publisher' => ['@type' => 'Organization', 'name' => $publisher ?: SITE_NAME, 'logo' => ['@type' => 'ImageObject', 'url' => SITE_LOGO]],
        'url' => $url,
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

/**
 * Print a JSON-LD script block.
 */
function seo_schema(string $json): void
{
    echo "\n<!-- Structured Data -->\n";
    echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
}
