<?php
require_once __DIR__.'/util.php';
start_vuln_session();
require_login();
$f = flags();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Dashboard</title>
</head>
<body>
  <h2>Dashboard</h2>
  <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>.</p>
  <?php if (!isset($_SESSION['2fa_ok']) || !$_SESSION['2fa_ok']): ?>
    <p style="color:#b00"><strong>Warning:</strong> Your account hasn't completed 2FA for this session.</p>
  <?php endif; ?>
  <p>Here is your user flag: <code><?php echo htmlspecialchars($f['auth_bypass']); ?></code></p>
  <?php if (is_admin()): ?>
    <p><a href="/admin.php">Admin panel</a></p>
  <?php else: ?>
    <p>No admin access. (Or is there a way?)</p>
  <?php endif; ?>
  <p><a href="/logout.php">Log out</a></p>
</body>
</html>
