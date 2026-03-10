
# Tri-Lab: Authentication, Session Management & Access Control (Vulnerable)

**Purpose**: A lab that chains authentication flaws, a session bug, and an access control weakness using Burp Suite.

### Accounts (initial)
- `wiener` (user)
- `administrator` (admin)
- `carlos` (user)

> Passwords are weak and stored as MD5 hashes. See `data/users.json`.

## Lab goals

1. **Authentication**: Enumerate users and brute-force a weak password, then **bypass 2FA** to reach the dashboard.
2. **Session management**: Demonstrate **session fixation** using the `sid` parameter **or** analyze the `rememberme` cookie.
3. **Access control**: Escalate privileges by abusing **Referer-based control** (`/admin-roles.php`) and retrieve the admin flag.

Flags you can collect:
- User flag on the dashboard
- Admin flag in `/admin.php`
- Extra: session fixation flag

## Burp Suite hints
- Use **Proxy → HTTP history** to spot different messages for *user not found* vs *invalid password*.
- Use **Intruder** with a tiny wordlist (`wordlist.txt`) to try a few candidate passwords.
- Use **Repeater** to:
  - Request `/dashboard.php` immediately after login to test 2FA enforcement.
  - Add a `Referer: https://two214practice.onrender.com/admin.php` header when calling `/admin-roles.php?username=wiener&action=upgrade`.
- Use **Decoder** to base64-decode the `rememberme` cookie.

> **Note**: This site is deliberately insecure and for local demo only.
