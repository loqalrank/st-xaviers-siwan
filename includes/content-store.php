<?php
require_once __DIR__ . '/storage.php';

/**
 * JSON content store for blog posts, FAQ items, gallery items and toppers.
 * The public site reads defaults from includes/site-config.php and overlays
 * any saved data from the resolved data directory.
 */

function content_store_dir(): string
{
    return sxhs_data_dir();
}

function content_store_path(): string
{
    return sxhs_data_file('content.json');
}

/**
 * @return array<string, array>
 */
function content_store_read(): array
{
    $path = content_store_path();
    if (!is_file($path)) {
        return [];
    }

    $raw = @file_get_contents($path);
    if ($raw === false || $raw === '') {
        return [];
    }

    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function content_store_write(array $data): bool
{
    $dir = content_store_dir();
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        return false;
    }

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    $path = content_store_path();
    $tmp  = $path . '.tmp';
    if (@file_put_contents($tmp, $json, LOCK_EX) === false) {
        return false;
    }

    return @rename($tmp, $path);
}

/**
 * Replace the managed lists in a site config array with saved data.
 *
 * @param array<string, mixed> $config
 * @return array<string, mixed>
 */
function content_store_overlay(array $config): array
{
    $saved = content_store_read();
    if (!$saved) {
        return $config;
    }

    $map = [
        'toppers'     => ['toppers', 'toppers'],
        'blog'        => ['blog', 'posts'],
        'faq'         => ['faq', 'items'],
        'gallery'     => ['gallery', 'items'],
        'hero_slides' => ['hero', 'slides'],
        'disclosure_docs' => ['mandatory_disclosure', 'documents'],
    ];

    foreach ($map as $section => $target) {
        list($configKey, $listKey) = $target;
        if (isset($saved[$section]) && is_array($saved[$section]) && isset($config[$configKey])) {
            $config[$configKey][$listKey] = array_values($saved[$section]);
        }
    }

    $categoryMap = [
        'faq_categories'     => 'faq',
        'gallery_categories' => 'gallery',
    ];

    foreach ($categoryMap as $section => $configKey) {
        if (isset($saved[$section]) && is_array($saved[$section]) && isset($config[$configKey])) {
            $config[$configKey]['categories'] = $saved[$section];
        }
    }

    if (isset($saved['admission_popup']) && is_array($saved['admission_popup'])) {
        $defaults = isset($config['admission_popup']) && is_array($config['admission_popup']) ? $config['admission_popup'] : [];
        $config['admission_popup'] = array_merge($defaults, $saved['admission_popup']);
    }

    if (isset($saved['site_images']) && is_array($saved['site_images']) && isset($config['site_images']) && is_array($config['site_images'])) {
        foreach ($saved['site_images'] as $imageKey => $imagePath) {
            if (isset($config['site_images'][$imageKey]) && is_array($config['site_images'][$imageKey])) {
                $config['site_images'][$imageKey]['path'] = (string) $imagePath;
            }
        }
    }

    return $config;
}

/**
 * Register the resolved site image map for the site_image() helper.
 *
 * @param array<string, array{label:string,path:string}> $images
 */
function site_images_register(array $images): void
{
    $GLOBALS['site_image_registry'] = $images;
}

function site_image(string $key, string $fallback = ''): string
{
    if (isset($GLOBALS['site_image_registry'][$key]['path']) && $GLOBALS['site_image_registry'][$key]['path'] !== '') {
        return (string) $GLOBALS['site_image_registry'][$key]['path'];
    }

    return $fallback;
}

/**
 * Persist one managed list, keeping the other saved sections intact.
 *
 * @param string $section toppers|blog|faq|gallery
 * @param array<int, array> $items
 */
function content_store_save_section(string $section, array $items): bool
{
    $allowed = ['toppers', 'blog', 'faq', 'gallery', 'hero_slides', 'disclosure_docs', 'site_images', 'faq_categories', 'gallery_categories', 'admission_popup'];
    if (!in_array($section, $allowed, true)) {
        return false;
    }

    $saved = content_store_read();
    if (substr($section, -11) === '_categories' || $section === 'admission_popup' || $section === 'site_images') {
        $saved[$section] = $items;
    } else {
        $saved[$section] = array_values($items);
    }

    return content_store_write($saved);
}
