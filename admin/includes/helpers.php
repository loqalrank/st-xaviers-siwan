<?php
/**
 * Small helpers used by the admin panel, copied out of the public site's
 * seo-helpers.php so the admin folder needs nothing from includes/.
 */

if (!function_exists('seo_slugify')) {
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
}
