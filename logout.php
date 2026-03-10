<?php
require_once __DIR__.'/util.php';
start_vuln_session();
setcookie('rememberme', '', time()-3600, '/');
session_destroy();
header('Location: /index.php');
