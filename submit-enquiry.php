<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/includes/leads-store.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
    exit;
}

// Honeypot: real users never fill this hidden field. Bots get a fake success.
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true, 'message' => 'Thank you. Your enquiry has been sent successfully.']);
    exit;
}

$clientIp = isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : 'unknown';
if (enquiry_rate_limited($clientIp)) {
    http_response_code(429);
    echo json_encode(['success' => false, 'error' => 'Too many submissions from this device. Please try again in a few minutes.']);
    exit;
}

// Determine form type
$formType = $_POST['form_type'] ?? 'admission';

if ($formType === 'contact') {
    $required = ['name', 'phone', 'email', 'address', 'subject', 'message', 'agree'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
            exit;
        }
    }
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    $consent = htmlspecialchars($_POST['agree'] ?? 'on', ENT_QUOTES, 'UTF-8');
    $emailSubject = "New Contact Message - St. Xavier's High School";
} else {
    $required = ['parent', 'phone', 'email', 'student', 'class', 'address', 'agree'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
            exit;
        }
    }
    $name = htmlspecialchars($_POST['parent'] ?? '', ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $student = htmlspecialchars($_POST['student'] ?? '', ENT_QUOTES, 'UTF-8');
    $class = htmlspecialchars($_POST['class'] ?? '', ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8');
    $consent = htmlspecialchars($_POST['agree'] ?? 'on', ENT_QUOTES, 'UTF-8');
    $emailSubject = "New Admission Enquiry - St. Xavier's High School";
}

if (!preg_match('/^[1-9][0-9]{9}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Mobile number must contain exactly 10 digits and must not start with 0.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Please enter a valid email address.']);
    exit;
}

$clean = function ($value, $limit = 300) {
    return mb_substr(trim(strip_tags((string) $value)), 0, $limit);
};

$lead = [
    'id'         => bin2hex(random_bytes(8)),
    'type'       => $formType === 'contact' ? 'contact' : 'admission',
    'name'       => $clean($formType === 'contact' ? ($_POST['name'] ?? '') : ($_POST['parent'] ?? ''), 120),
    'phone'      => preg_replace('/\D/', '', (string) ($_POST['phone'] ?? '')),
    'email'      => $clean($_POST['email'] ?? '', 160),
    'student'    => $formType === 'contact' ? '' : $clean($_POST['student'] ?? '', 120),
    'class'      => $formType === 'contact' ? '' : $clean($_POST['class'] ?? '', 60),
    'subject'    => $formType === 'contact' ? $clean($_POST['subject'] ?? '', 160) : '',
    'address'    => $clean($_POST['address'] ?? '', 300),
    'message'    => $clean($_POST['message'] ?? '', 2000),
    'consent'    => empty($_POST['agree']) ? 'no' : 'yes',
    'status'     => 'new',
    'created_at' => date('c'),
];

// SMTP settings
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'loqalrank@gmail.com';
$smtpPassword = 'waomwslzhwhlljof';
$smtpFrom = 'stxavierssiwan@gmail.com';
$mailTo = 'stxavierssiwan@gmail.com';

// Build HTML email body using the template
$fields = [];
$fields['Form Type'] = $formType === 'contact' ? 'contact' : 'admission';
if ($formType === 'contact') {
    $fields['Name'] = $name;
    $fields['Phone'] = $phone;
    $fields['Email'] = $email;
    $fields['Address'] = $address;
    $fields['Subject'] = $subject;
    $fields['Message'] = $message;
} else {
    $fields['Parent/Guardian'] = $name;
    $fields['Phone'] = $phone;
    $fields['Email'] = $email;
    $fields['Student Name'] = $student;
    $fields['Class'] = $class;
    $fields['Address'] = $address;
    $fields['Message'] = $message;
}
$fields['Consent'] = $consent;

$rows = '';
foreach ($fields as $key => $value) {
    $valueHtml = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    if (strtolower($key) === 'email') {
        $valueHtml = '<a href="mailto:' . $valueHtml . '" target="_blank">' . $valueHtml . '</a>';
    }
    $rows .= '<tr><th align="left" style="padding:10px;border:1px solid #d9e2ec;background:#f3f7fa;font-size:14px">' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '</th><td style="padding:10px;border:1px solid #d9e2ec;font-size:14px">' . nl2br($valueHtml, false) . '</td></tr>';
}

$html = '<table style="width:100%;border-collapse:collapse"><tbody>' . $rows . '</tbody></table>';

function readSmtpLine($socket) {
    $data = '';
    while (($line = fgets($socket, 515)) !== false) {
        $data .= $line;
        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }
    return $data;
}

function sendMail($host, $port, $user, $pass, $from, $to, $subject, $html, $replyTo) {
    $remote = ($port === 465) ? 'ssl://' . $host : $host;
    $socket = @fsockopen($remote, $port, $errno, $errstr, 30);
    if (!$socket) return false;
    stream_set_timeout($socket, 30);
    
    readSmtpLine($socket);
    fputs($socket, "EHLO localhost\r\n");
    readSmtpLine($socket);
    
    if ($port !== 465) {
        fputs($socket, "STARTTLS\r\n");
        readSmtpLine($socket);
        if (!@stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            fclose($socket);
            return false;
        }
        fputs($socket, "EHLO localhost\r\n");
        readSmtpLine($socket);
    }
    
    if ($user && $pass) {
        fputs($socket, "AUTH LOGIN\r\n");
        readSmtpLine($socket);
        fputs($socket, base64_encode($user) . "\r\n");
        readSmtpLine($socket);
        fputs($socket, base64_encode($pass) . "\r\n");
        $auth = readSmtpLine($socket);
        if (strpos($auth, '235') === false) {
            fclose($socket);
            return false;
        }
    }
    
    fputs($socket, "MAIL FROM:<$from>\r\n");
    readSmtpLine($socket);
    fputs($socket, "RCPT TO:<$to>\r\n");
    readSmtpLine($socket);
    fputs($socket, "DATA\r\n");
    readSmtpLine($socket);
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $from\r\n";
    $headers .= "To: $to\r\n";
    if ($replyTo) $headers .= "Reply-To: $replyTo\r\n";
    $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
    
    fputs($socket, $headers . "\r\n" . $html . "\r\n.\r\n");
    $result = readSmtpLine($socket);
    fputs($socket, "QUIT\r\n");
    fclose($socket);
    
    return strpos($result, '250') !== false;
}

$sent = sendMail($smtpHost, $smtpPort, $smtpUsername, $smtpPassword, $smtpFrom, $mailTo, $emailSubject, $html, $email);

$lead['email_sent'] = $sent;
leads_add($lead);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Thank you. Your enquiry has been sent successfully.']);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to send enquiry. Please try again.']);
}
