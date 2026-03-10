<?php
require_once __DIR__.'/util.php';
start_vuln_session();
require_login();
if (!is_admin()) { http_response_code(403); die('Forbidden: admins only'); }
$f = flags();
$users = load_users();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Admin</title>
</head>
<body>
  <h2>Admin panel</h2>
  <p>Admin flag: <code><?php echo htmlspecialchars($f['admin_upgrade']); ?></code></p>
  <h3>Users</h3>
  <table border="1" cellpadding="6" cellspacing="0"><tr><th>User</th><th>Role</th></tr>
  <?php foreach ($users as $u => $info): ?>
    <tr><td><?php echo htmlspecialchars($u); ?></td><td><?php echo htmlspecialchars($info['role']); ?></td></tr>
  <?php endforeach; ?>
  </table>
  <p>
    <a href="/admin-roles.php?username=wiener&action=upgrade">(API) Upgrade wiener</a> |
    <a href="/admin-roles.php?username=wiener&action=downgrade">(API) Downgrade wiener</a>
  </p>
  <p><a href="/dashboard.php">Back</a></p>
</body>
</html>
