
# Instructor Guide & Suggested Solution Path

**Estimated time**: 60–90 minutes with Burp Suite Community Edition.

## What this lab maps to in prior weeks
- **Authentication** techniques & PortSwigger labs (username enumeration, 2FA simple bypass, stay-logged-in cookie). (Week 8)
- **Session Management** demonstrations (analyzing tokens, structured/opaque data). (Week 9)
- **Access Control** tests (Referer-based control). (Week 10)

## Walkthrough

### 1) Authentication & 2FA simple bypass
- Browse to `/login.php` and submit an invalid username like `alice` → server says **User not found**.
- Try valid username `wiener` with wrong password → message switches to **Invalid password** → enumeration confirmed.
- Use Intruder with `wiener` and payloads from `wordlist.txt`. The correct password is `monkey`.
- After login you are redirected to `/2fa.php` with a hidden server-side OTP.
- **Bypass**: Directly request `/dashboard.php` using Burp Repeater (same session). The page forgets to enforce 2FA.
- **Flag**: `FLAG1_AUTH_BYPASS_7BB0B4` appears on the dashboard.

### 2) Session management issue (choose one)
**A. Session fixation**
- Start a new browser tab and visit `http://localhost:8000/login.php?sid=SESS1234FIXME`.
- Log in as `wiener:monkey`.
- Observe that the session ID value in your browser cookie is exactly `SESS1234FIXME` (Burp → Proxy → Cookies). This demonstrates server acceptance of attacker-supplied IDs.
- Record **Flag**: `FLAG3_SESSION_FIXATION_A4D9F0` (instructor can reveal or students submit evidence: fixed session cookie + request sequence).

**B. Weak remember-me cookie** (alternative or extra)
- Log out, log back in with **Remember me** ticked.
- In Burp, view the `rememberme` cookie: base64 decode → `username:md5(password)`.
- With a small list you can offline match MD5(`monkey`).

### 3) Access control: Referer-based control
- As `wiener` (non-admin), requesting `/admin.php` shows 403.
- Send this request via Repeater:
  GET `/admin-roles.php?username=wiener&action=upgrade`
  Add header: `Referer: http://localhost:8000/admin.php`
- Response `OK`. Visit `/admin.php` → now shows **Admin flag**: `FLAG2_ADMIN_UPGRADE_91C2E1`.

## Grading rubric (suggested)
- Enumeration + brute-force demonstrated (screenshots + request IDs): 30%
- 2FA bypass proven (HTTP history showing redirect and direct access): 25%
- Session issue demonstrated (fixation or remember-me analysis): 20%
- Access control abuse with crafted Referer: 25%

## Resetting state
- If roles get changed, edit `data/users.json` and set `"wiener": { "role": "user" }`.

