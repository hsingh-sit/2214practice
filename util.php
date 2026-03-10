<?php
// util.php - intentionally vulnerable helpers
function start_vuln_session() {
    // Accept attacker-supplied session IDs via GET (session fixation)
    if (isset($_GET['sid']) && preg_match('/^[A-Za-z0-9]{8,40}$/', $_GET['sid'])) {
        session_id($_GET['sid']);
    }
    session_start();

    // Poor-man's IP binding (not enforced)
    if (!isset($_SESSION['ip'])) { $_SESSION['ip'] = $_SERVER['REMOTE_ADDR']; }

    // Weak "remember me": base64(username:md5(password))
    if (!isset($_SESSION['user']) && isset($_COOKIE['rememberme'])) {
        $raw = base64_decode($_COOKIE['rememberme']);
        if ($raw !== false && strpos($raw, ':') !== false) {
            list($u, $h) = explode(':', $raw, 2);
            $user = get_user($u);
            if ($user && strtolower($user['password_md5']) === strtolower($h)) {
                $_SESSION['user'] = $u;
                $_SESSION['role'] = $user['role'];
                // Force 2FA pending again (dashboard forgets to check it)
                $_SESSION['2fa_ok'] = false;
            }
        }
    }
}

function load_users() { return json_decode(file_get_contents(__DIR__.'/data/users.json'), true); }
function save_users($u) { file_put_contents(__DIR__.'/data/users.json', json_encode($u, JSON_PRETTY_PRINT)); }
function get_user($u) { $users = load_users(); return isset($users[$u]) ? $users[$u] : null; }
function set_role($u, $role) { $users = load_users(); if (isset($users[$u])) { $users[$u]['role'] = $role; save_users($users); return true; } return false; }
function require_login() { if (!isset($_SESSION['user'])) { header('Location: /login.php'); exit; } }
function is_admin() { return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'); }
function flags() { return json_decode(file_get_contents(__DIR__.'/data/flags.json'), true); }
?>
