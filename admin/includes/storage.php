<?php
/**
 * Self-contained storage layer for the admin panel.
 *
 * All admin-related data lives under the admin folder (by default
 * <admin>/data). Uploaded images/documents live under
 * <admin>/assets/uploads and <admin>/assets/documents.
 *
 * Every path is resolved relative to ADMIN_ROOT, so the whole admin/
 * folder can be copied into another project and work without editing
 * any path. Override locations with the ADMIN_DATA_DIR,
 * ADMIN_UPLOAD_DIR and ADMIN_PDF_DIR environment variables.
 */

define('ADMIN_ROOT', dirname(__DIR__));
define('ADMIN_DATA_DIR', getenv('ADMIN_DATA_DIR') ?: ADMIN_ROOT . DIRECTORY_SEPARATOR . 'data');
define('ADMIN_UPLOAD_DIR', getenv('ADMIN_UPLOAD_DIR') ?: ADMIN_ROOT . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads');
define('ADMIN_UPLOAD_REL', 'admin/assets/uploads');
define('ADMIN_PDF_DIR', getenv('ADMIN_PDF_DIR') ?: ADMIN_ROOT . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'documents');
define('ADMIN_PDF_REL', 'admin/assets/documents');

if (!function_exists('admin_data_dir')) {
    function admin_data_dir(): string
    {
        return ADMIN_DATA_DIR;
    }
}

if (!function_exists('admin_data_file')) {
    function admin_data_file(string $name): string
    {
        return ADMIN_DATA_DIR . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $name), DIRECTORY_SEPARATOR);
    }
}

if (!function_exists('admin_read_json')) {
    /**
     * Read a JSON file from the admin data directory.
     */
    function admin_read_json(string $name): array
    {
        $path = admin_data_file($name);
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
}

if (!function_exists('admin_write_json')) {
    /**
     * Atomically write a JSON file. $path may be anywhere writable.
     */
    function admin_write_json(string $path, array $data): bool
    {
        $dir = dirname($path);
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return false;
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            return false;
        }

        $tmp = $path . '.tmp';
        if (@file_put_contents($tmp, $json, LOCK_EX) === false) {
            return false;
        }

        return @rename($tmp, $path);
    }
}

if (!function_exists('admin_protect_dir')) {
    /**
     * Write .htaccess / web.config so the directory cannot be used to run
     * PHP (or, for data/, cannot be browsed at all) on Apache, IIS and
     * any server that honours these files.
     */
    function admin_protect_dir(string $dir, bool $denyAll = false): void
    {
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return;
        }

        if ($denyAll) {
            $rules = "# Deny direct web access to this directory.\n"
                . "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n"
                . "<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n";
        } else {
            $rules = "# Uploaded files only; never execute scripts from this directory.\n"
                . "<IfModule mod_authz_core.c>\n    <FilesMatch \"\\.(php|phtml|phar|php3|php4|php5|php7|phps|cgi|pl|py|sh|asp|aspx|jsp)$\">\n        Require all denied\n    </FilesMatch>\n</IfModule>\n"
                . "<IfModule !mod_authz_core.c>\n    <FilesMatch \"\\.(php|phtml|phar|php3|php4|php5|php7|phps|cgi|pl|py|sh|asp|aspx|jsp)$\">\n        Order allow,deny\n        Deny from all\n    </FilesMatch>\n</IfModule>\n";
        }

        $htaccess = $dir . DIRECTORY_SEPARATOR . '.htaccess';
        if (!is_file($htaccess)) {
            @file_put_contents($htaccess, $rules);
        }

        $webConfig = $dir . DIRECTORY_SEPARATOR . 'web.config';
        if (!is_file($webConfig) && $denyAll) {
            $iis = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"
                . "<configuration>\n  <system.webServer>\n    <security>\n      <authorization>\n        <remove users=\"*\" roles=\"\" verbs=\"\" />\n        <add accessType=\"Deny\" users=\"*\" />\n      </authorization>\n    </security>\n  </system.webServer>\n</configuration>\n";
            @file_put_contents($webConfig, $iis);
        }
    }
}

/**
 * Ensure the admin-owned directories exist and are protected.
 */
if (!function_exists('admin_ensure_dirs')) {
    function admin_ensure_dirs(): void
    {
        admin_protect_dir(admin_data_dir(), true);
        admin_protect_dir(ADMIN_UPLOAD_DIR, false);
        admin_protect_dir(ADMIN_PDF_DIR, false);
    }
}
