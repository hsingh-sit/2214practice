<?php
require_once __DIR__.'/util.php';
start_vuln_session();
require_login();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'] ?? '';
    if (isset($_SESSION['otp']) && $otp === $_SESSION['otp']) {
        $_SESSION['2fa_ok'] = true;
        header('Location: /dashboard.php');
        exit;
    } else {
        $msg = 'Invalid or expired code.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title>2FA Verification</title>
</head>
<body>
  <h2>Two-Factor Authentication</h2>
  <p>Enter the 6-digit code sent to your email.</p>
  <?php if ($msg): ?><p style="color:#b00;"><strong><?php echo htmlspecialchars($msg); ?></strong></p><?php endif; ?>
  <form method="post">
    <div><label>One-time code: <input name="otp" maxlength="6" /></label></div>
    <button type="submit">Verify</button>
  </form>
  <p><em>Hint (developer debug): the current code is generated server-side, but some pages may not enforce 2FA.</em></p>
  <p><a href="/logout.php">Log out</a></p>
</body>
</html>
