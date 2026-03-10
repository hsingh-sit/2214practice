<?php
require_once __DIR__.'/util.php';
start_vuln_session();
require_login();

// Vulnerable access control: trusts Referer instead of enforcing role
$ref = $_SERVER['HTTP_REFERER'] ?? '';
if (strpos($ref, '/admin.php') === false) {
    http_response_code(401);
    die('Unauthorized: missing or invalid Referer');
}

$user = $_GET['username'] ?? '';
$action = $_GET['action'] ?? '';
if (!$user || !$action) { die('Missing parameters'); }

if ($action === 'upgrade') { $ok = set_role($user, 'admin'); }
else if ($action === 'downgrade') { $ok = set_role($user, 'user'); }
else { $ok = false; }

echo $ok ? "OK" : "Failed";
?>
