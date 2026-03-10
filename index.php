<?php
require_once __DIR__.'/util.php';
start_vuln_session();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Tri-Lab: Authentication + Session + Access Control</title>
  <style>body{font-family:system-ui,Segoe UI,Arial,sans-serif;margin:2rem} code{background:#f4f4f4;padding:2px 4px;border-radius:3px}</style>
</head>
<body>
  <h1>Tri-Lab: Identity & Access Management (Vulnerable)</h1>
  <p>This deliberately vulnerable mini-site is for education only. Use it locally.</p>
  <ul>
    <li><a href="/login.php">Login</a></li>
    <li><a href="/dashboard.php">Dashboard</a></li>
    <li><a href="/admin.php">Admin panel</a></li>
  </ul>
  <p>Tip: run with <code>php -S localhost:8000</code> in this folder or use Docker (see README).</p>
</body>
</html>
