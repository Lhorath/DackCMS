<?php
/**
 * Dacks CMS - Contact form handler
 *
 * Validates POST data, optionally sends mail, and always logs a line for auditing.
 */

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . get_page_url('home'));
    exit();
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$subject = trim((string) ($_POST['subject'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

$errors = [];

if ($name === '' || strlen($name) > 120) {
    $errors[] = 'Please enter a valid name (max 120 characters).';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}
if ($subject === '' || strlen($subject) > 200) {
    $errors[] = 'Please enter a subject (max 200 characters).';
}
if ($message === '' || strlen($message) > 10000) {
    $errors[] = 'Please enter a message (max 10000 characters).';
}

$now = time();
$last = (int) ($_SESSION['contact_form_last_submit'] ?? 0);
if ($last > 0 && ($now - $last) < 60) {
    $errors[] = 'Please wait a minute before sending another message.';
}

if ($errors !== []) {
    $_SESSION['flash_errors'] = $errors;
    header('Location: ' . get_page_url('contact'));
    exit();
}

$_SESSION['contact_form_last_submit'] = $now;

$log_line = sprintf(
    "[%s] Contact from %s <%s> | %s | %s\n",
    gmdate('c'),
    $name,
    $email,
    $subject,
    str_replace(["\r", "\n"], ' ', substr($message, 0, 500))
);
$contact_log = ROOT_PATH . '/logs/contact.log';
if (is_writable(dirname($contact_log)) || is_writable($contact_log)) {
    @file_put_contents($contact_log, $log_line, FILE_APPEND | LOCK_EX);
}
error_log('Contact form: ' . trim($log_line));

$to = CONTACT_FORM_TO;
if ($to !== '' && filter_var($to, FILTER_VALIDATE_EMAIL)) {
    $safe_subject = 'Contact: ' . str_replace(["\r", "\n"], '', $subject);
    $body = "Name: {$name}\nEmail: {$email}\n\n" . $message;
    $host = preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
    $from_addr = 'noreply@' . $host;
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $from_addr,
        'Reply-To: ' . $email,
        'X-Mailer: PHP/' . PHP_VERSION,
    ];
    @mail($to, $safe_subject, $body, implode("\r\n", $headers));
}

$_SESSION['flash_message'] = 'Thank you — your message has been received.';
header('Location: ' . get_page_url('contact'));
exit();
