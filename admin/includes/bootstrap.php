<?php
/**
 * Admin bootstrap: session, auth, CSRF, flash messages and helpers.
 *
 * Self-contained: every path resolves relative to ADMIN_ROOT (the admin/
 * folder itself). All data lives under admin/data, uploads under
 * admin/assets/uploads and documents under admin/assets/documents.
 * Override with ADMIN_DATA_DIR, ADMIN_UPLOAD_DIR, ADMIN_PDF_DIR and
 * ADMIN_SESSION_NAME environment variables.
 */

require_once __DIR__ . '/storage.php';
require_once __DIR__ . '/content-store.php';
require_once __DIR__ . '/leads-store.php';
require_once __DIR__ . '/helpers.php';

admin_ensure_dirs();

$adminHttps = (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off');
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name(getenv('ADMIN_SESSION_NAME') ?: 'sxhs_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => $adminHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

if (!headers_sent()) {
    header('X-Robots-Tag: noindex, nofollow, noarchive', true);
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function admin_credentials_path(): string
{
    return admin_data_file('admin.json');
}

/**
 * Load admin credentials, seeding the default admin/admin123 account.
 *
 * @return array{username:string,password_hash:string,must_change:bool}|null
 */
function admin_credentials(): ?array
{
    static $cached = null;
    if ($cached !== null) {
        return $cached;
    }

    $path = admin_credentials_path();
    if (is_file($path)) {
        $raw = @file_get_contents($path);
        $data = $raw ? json_decode($raw, true) : null;
        if (is_array($data) && !empty($data['username']) && !empty($data['password_hash'])) {
            return $cached = [
                'username'    => (string) $data['username'],
                'password_hash' => (string) $data['password_hash'],
                'must_change' => !empty($data['must_change']),
            ];
        }
        return null;
    }

    $default = [
        'username'      => 'admin',
        'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
        'must_change'   => true,
        'updated_at'    => date('c'),
    ];
    if (admin_write_json($path, $default)) {
        return $cached = [
            'username'      => $default['username'],
            'password_hash' => $default['password_hash'],
            'must_change'   => true,
        ];
    }

    return null;
}

/**
 * Site config with saved JSON content overlaid.
 * Fully self-contained defaults; saved content is read from admin/data.
 */
function admin_default_config(): array
{
    return [
        'site_name'           => "St. Xavier's High School",
        'site_url'            => 'https://example.org',
        'pages'               => [],
        'toppers'             => ['toppers' => []],
        'blog'                => ['posts' => [], 'tags' => []],
        'faq'                 => ['categories' => [], 'items' => []],
        'gallery'             => ['categories' => [], 'items' => []],
        'hero'                => ['slides' => []],
        'mandatory_disclosure' => ['documents' => []],
        'admission_popup'     => [
            'eyebrow'           => 'Admissions Open',
            'year'              => date('Y'),
            'title'             => 'Admission Enquiry',
            'title_accent'      => 'Open Now',
            'subline'           => '',
            'cta_label'         => 'Enquire Now',
            'image'             => '',
            'auto_close_seconds'=> 30,
            'pages'             => [],
        ],
        'site_images'         => [
            'home_welcome'    => ['label' => 'Home - Welcome photo', 'path' => ''],
            'home_spotlight_1'=> ['label' => 'Home - Gallery card 1', 'path' => ''],
            'home_spotlight_2'=> ['label' => 'Home - Gallery card 2', 'path' => ''],
            'home_spotlight_3'=> ['label' => 'Home - Gallery card 3', 'path' => ''],
            'about_hero'      => ['label' => 'About Us - Main image', 'path' => ''],
            'academics_hero'  => ['label' => 'Academics - Main image', 'path' => ''],
            'facilities_hero' => ['label' => 'Facilities - Hero image', 'path' => ''],
            'messages_hero'   => ['label' => 'Messages - Main image', 'path' => ''],
        ],
    ];
}

function admin_config(): array
{
    static $config = null;
    if ($config === null) {
        $config = content_store_overlay(admin_default_config());
    }

    return $config;
}

/**
 * Handle an image upload and return its stored relative path.
 * Returns $current when no file was sent.
 *
 * @throws RuntimeException on invalid uploads
 */
function admin_handle_upload(string $field, string $current = ''): string
{
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return $current;
    }

    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. Please try again.');
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be smaller than 5 MB.');
    }

    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        throw new RuntimeException('The uploaded file is not a valid image.');
    }

    $allowed = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_WEBP => 'webp',
        IMAGETYPE_GIF  => 'gif',
    ];
    if (!isset($allowed[$info[2]])) {
        throw new RuntimeException('Only JPG, PNG, WEBP or GIF images are allowed.');
    }

    if (!is_dir(ADMIN_UPLOAD_DIR) && !@mkdir(ADMIN_UPLOAD_DIR, 0775, true) && !is_dir(ADMIN_UPLOAD_DIR)) {
        throw new RuntimeException('Upload directory is not writable.');
    }

    $name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.' . $allowed[$info[2]];
    $target = ADMIN_UPLOAD_DIR . DIRECTORY_SEPARATOR . $name;

    if (!@move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Could not save the uploaded image.');
    }

    return ADMIN_UPLOAD_REL . '/' . $name;
}

/**
 * Handle a PDF upload and return its stored relative path.
 * Returns $current when no file was sent.
 *
 * @throws RuntimeException on invalid uploads
 */
function admin_handle_pdf_upload(string $field, string $current = ''): string
{
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return $current;
    }

    $file = $_FILES[$field];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed. Please try again.');
    }

    if ($file['size'] > 10 * 1024 * 1024) {
        throw new RuntimeException('PDF must be smaller than 10 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if ($mime !== 'application/pdf') {
        throw new RuntimeException('Only PDF files are allowed.');
    }

    $head = @file_get_contents($file['tmp_name'], false, null, 0, 5);
    if ($head !== '%PDF-') {
        throw new RuntimeException('The uploaded file is not a valid PDF.');
    }

    if (!is_dir(ADMIN_PDF_DIR) && !@mkdir(ADMIN_PDF_DIR, 0775, true) && !is_dir(ADMIN_PDF_DIR)) {
        throw new RuntimeException('Document directory is not writable.');
    }

    $name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.pdf';
    $target = ADMIN_PDF_DIR . DIRECTORY_SEPARATOR . $name;

    if (!@move_uploaded_file($file['tmp_name'], $target)) {
        throw new RuntimeException('Could not save the uploaded PDF.');
    }

    return ADMIN_PDF_REL . '/' . $name;
}

function admin_login(string $username, string $password): bool
{
    $creds = admin_credentials();
    if (!$creds) {
        return false;
    }
    if (!hash_equals($creds['username'], $username)) {
        return false;
    }
    if (!password_verify($password, $creds['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_user'] = $creds['username'];
    $_SESSION['admin_login_at'] = time();

    return true;
}

function admin_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function admin_user(): ?string
{
    return isset($_SESSION['admin_user']) ? (string) $_SESSION['admin_user'] : null;
}

function admin_require_login(): void
{
    if (admin_user() === null) {
        header('Location: login.php');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['admin_csrf'])) {
        $_SESSION['admin_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['admin_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_verify(): void
{
    $sent = isset($_POST['_csrf']) ? (string) $_POST['_csrf'] : '';
    if ($sent === '' || empty($_SESSION['admin_csrf']) || !hash_equals($_SESSION['admin_csrf'], $sent)) {
        http_response_code(400);
        exit('Invalid request token. Please reload the page and try again.');
    }
}

function admin_flash(string $type, string $message): void
{
    $_SESSION['admin_flash'][] = ['type' => $type, 'message' => $message];
}

function admin_flash_all(): array
{
    $messages = isset($_SESSION['admin_flash']) ? $_SESSION['admin_flash'] : [];
    unset($_SESSION['admin_flash']);

    return is_array($messages) ? $messages : [];
}

function admin_redirect(string $location): void
{
    header('Location: ' . $location);
    exit;
}
