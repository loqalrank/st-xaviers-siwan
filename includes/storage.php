<?php
/**
 * Resolve the writable data directory.
 *
 * Preference order:
 *   1. SXHS_DATA_DIR environment variable
 *   2. A "sxhs-data" folder next to the project (outside the web root)
 *   3. The legacy ./data folder inside the project (Apache .htaccess protected)
 *
 * Existing files in ./data are migrated automatically to the first usable
 * location the first time this runs.
 */

if (!function_exists('sxhs_data_dir')) {
    function sxhs_data_dir(): string
    {
        static $dir = null;
        if ($dir !== null) {
            return $dir;
        }

        $projectRoot = dirname(__DIR__);
        $legacy      = $projectRoot . DIRECTORY_SEPARATOR . 'data';
        $candidates  = [];

        $env = getenv('SXHS_DATA_DIR');
        if (is_string($env) && trim($env) !== '') {
            $candidates[] = rtrim(trim($env), '/\\');
        }

        // Shared with the admin panel: all admin (and public) content lives
        // under <project>/admin/data so the admin folder is self-contained.
        $candidates[] = $projectRoot . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'data';

        $outside = dirname($projectRoot);
        if (in_array(strtolower(basename($outside)), ['public_html', 'public', 'www', 'htdocs', 'httpdocs', 'wwwroot', 'html', 'web'], true)) {
            $outside = dirname($outside);
        }
        $candidates[] = $outside . DIRECTORY_SEPARATOR . 'sxhs-data';
        $candidates[] = $legacy;

        $chosen = null;
        foreach ($candidates as $candidate) {
            if (!is_dir($candidate) && !@mkdir($candidate, 0775, true) && !is_dir($candidate)) {
                continue;
            }
            if (is_writable($candidate)) {
                $chosen = $candidate;
                break;
            }
        }

        if ($chosen === null) {
            $chosen = $legacy;
        }

        if ($chosen !== $legacy) {
            $htaccess = $chosen . DIRECTORY_SEPARATOR . '.htaccess';
            if (!is_file($htaccess)) {
                $rules = "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n";
                @file_put_contents($htaccess, $rules);
            }
            $webConfig = $chosen . DIRECTORY_SEPARATOR . 'web.config';
            if (!is_file($webConfig)) {
                $iis = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<configuration>\n  <system.webServer>\n    <security>\n      <authorization>\n        <remove users=\"*\" roles=\"\" verbs=\"\" />\n        <add accessType=\"Deny\" users=\"*\" />\n      </authorization>\n    </security>\n  </system.webServer>\n</configuration>\n";
                @file_put_contents($webConfig, $iis);
            }
        }

        if ($chosen !== $legacy && is_dir($legacy)) {
            foreach (['admin.json', 'content.json', 'leads.json', 'rate.json'] as $name) {
                $source = $legacy . DIRECTORY_SEPARATOR . $name;
                $target = $chosen . DIRECTORY_SEPARATOR . $name;
                if (is_file($source) && !is_file($target)) {
                    if (@copy($source, $target)) {
                        @unlink($source);
                    }
                }
            }
        }

        $oldSxhsData = dirname($projectRoot) . DIRECTORY_SEPARATOR . 'sxhs-data';
        if ($chosen !== $oldSxhsData && is_dir($oldSxhsData)) {
            foreach (['admin.json', 'content.json', 'leads.json', 'rate.json'] as $name) {
                $source = $oldSxhsData . DIRECTORY_SEPARATOR . $name;
                $target = $chosen . DIRECTORY_SEPARATOR . $name;
                if (is_file($source) && !is_file($target)) {
                    if (@copy($source, $target)) {
                        @unlink($source);
                    }
                }
            }
        }

        return $dir = $chosen;
    }
}

if (!function_exists('sxhs_data_file')) {
    function sxhs_data_file(string $name): string
    {
        return sxhs_data_dir() . DIRECTORY_SEPARATOR . ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $name), DIRECTORY_SEPARATOR);
    }
}
