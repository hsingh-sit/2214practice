<?php
require_once __DIR__.'/util.php';
start_vuln_session();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    $u = get_user($username);
    if (!$u) {
        // Username enumeration via response difference
        $msg = 'User not found.'; // reveals whether user exists
    } else if (md5($password) !== $u['password_md5']) {
        $msg = 'Invalid password.'; // different message for wrong password
    } else {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $u['role'];
        $_SESSION['2fa_ok'] = false;
        $_SESSION['otp'] = str_pad(strval(rand(0, 999999)), 6, '0', STR_PAD_LEFT);
        if ($remember) {
            setcookie('rememberme', base64_encode($username . ':' . md5($password)), time()+60*60*24*7, '/');
        }
        header('Location: /2fa.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <?php if ($msg): ?><p style="color:#b00;"><strong><?php echo htmlspecialchars($msg); ?></strong></p><?php endif; ?>
  <form method="post">
    <div><label>Username: <input name="username" /></label></div>
    <div><label>Password: <input name="password" type="password" /></label></div>
    <div><label><input type="checkbox" name="remember" /> Remember me</label></div>
    <button type="submit">Sign in</button>
  </form>
  <p><a href="/index.php">Home</a></p>
</body>
</html>
