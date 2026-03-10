
# Tri-Lab: Authentication, Session Management & Access Control (Vulnerable)

**Purpose**: One self-contained lab that chains auth flaws, a session bug, and an access control weakness using Burp Suite.

## Quick start (PHP built-in server)

1. Ensure PHP is installed (`php -v`).
2. In this folder, run: `php -S localhost:8000`
3. Browse to: http://localhost:8000

### Accounts (initial)
- `wiener` (user)
- `administrator` (admin)
- `carlos` (user)

> Passwords are weak and stored as MD5 hashes. See `data/users.json`.

## Lab goals (student view)

1. **Authentication**: Enumerate users and brute-force a weak password, then **bypass 2FA** to reach the dashboard.
2. **Session management**: Demonstrate **session fixation** using the `sid` parameter **or** analyze the `rememberme` cookie.
3. **Access control**: Escalate privileges by abusing **Referer-based control** (`/admin-roles.php`) and retrieve the admin flag.

Flags you can collect:
- User flag on the dashboard
- Admin flag in `/admin.php`
- Extra: session fixation flag (see Instructor notes)

## Burp Suite hints
- Use **Proxy → HTTP history** to spot different messages for *user not found* vs *invalid password*.
- Use **Intruder** with a tiny wordlist (`wordlist.txt`) to try a few candidate passwords.
- Use **Repeater** to:
  - Request `/dashboard.php` immediately after login to test 2FA enforcement.
  - Add a `Referer: http://localhost:8000/admin.php` header when calling `/admin-roles.php?username=wiener&action=upgrade`.
- Use **Decoder** to base64-decode the `rememberme` cookie.

> **Note**: This site is deliberately insecure and for local demo only.


---

## Run with Docker (no PHP install needed)

### Build the image (one-time)
```bash
docker build -t iam-trilab .
```

### Run the container
```bash
docker run --rm -p 8000:80 iam-trilab
```
Then browse to: http://localhost:8000

> Optional (persist `data/` between runs):
> - **macOS/Linux**
>   ```bash
>   docker run --rm -p 8000:80 -v "$PWD/data:/var/www/html/data" iam-trilab
>   ```
> - **Windows PowerShell**
>   ```powershell
>   docker run --rm -p 8000:80 -v ${PWD}\data:/var/www/html/data iam-trilab
>   ```

### Using docker-compose (alternative)
```bash
docker compose up --build
```
Browse to `http://localhost:8000` and press **Ctrl+C** to stop.
