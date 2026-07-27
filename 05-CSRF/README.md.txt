# Cross-Site Request Forgery (CSRF)

## Overview

This lab demonstrates a **Cross-Site Request Forgery (CSRF)** vulnerability in a PHP banking application. The vulnerable implementation allows an attacker to trick an authenticated user into performing an unintended money transfer without their knowledge.

The secure implementation prevents the attack by generating a cryptographically secure CSRF token, storing it in the user's session, and validating it using `hash_equals()` before processing the request.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how CSRF attacks work.
- Explain why authenticated sessions are vulnerable to forged requests.
- Build a vulnerable PHP banking application.
- Demonstrate a CSRF attack in a controlled environment.
- Prevent CSRF using synchronizer tokens.
- Understand the relationship between sessions and CSRF protection.

---

## Lab Structure

```
05-CSRF/
│
├── vulnerable/
│   ├── login.php
│   ├── transfer.php
│   ├── logout.php
│   └── db.php
│
├── secure/
│   ├── login.php
│   ├── transfer.php
│   ├── logout.php
│   └── db.php
│
└── README.md
```

---

## Vulnerability Description

The vulnerable application allows authenticated users to transfer money without verifying whether the request originated from the legitimate application.

An attacker can create a malicious webpage that automatically submits a forged request to the banking application. Because the victim is already authenticated, the browser automatically includes the session cookie, causing the server to treat the request as legitimate.

---

## Root Cause

The application relied solely on the user's authenticated session.

Application flow:

1. User logs into the banking application.
2. The server creates a valid PHP session.
3. The user visits a malicious website while still logged in.
4. The malicious site submits a forged POST request.
5. The browser automatically includes the session cookie.
6. The server processes the request because no CSRF validation is performed.

The attacker never needs to know or steal the user's password or session cookie.

---

## Impact

Successful exploitation may allow an attacker to:

- Perform unauthorized money transfers.
- Change account settings.
- Update email addresses.
- Modify passwords.
- Trigger any state-changing action available to the authenticated user.

---

## Mitigation

The secure implementation generates a cryptographically secure token:

```php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
```

The token is embedded within the HTML form:

```php
<input
    type="hidden"
    name="csrf_token"
    value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
```

When the form is submitted, the application validates the submitted token against the value stored in the user's session.

```php
if (
    !isset($_POST['csrf_token']) ||
    !hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token']
    )
) {
    exit("Invalid CSRF Token.");
}
```

Only requests containing a valid token are processed.

---

## Additional Security Measures

The login process regenerates the session identifier after successful authentication.

```php
session_regenerate_id(true);
```

This helps mitigate Session Fixation attacks by issuing a new session identifier after login.

---

## Testing Performed

### Legitimate Request

- User logged into the application.
- Submitted the transfer form.
- Request completed successfully.

---

### Forged Request

A malicious HTML page attempted to submit a transfer request without a valid CSRF token.

Result:

- Vulnerable version:
  - Request processed successfully.

- Secure version:
  - Request rejected.
  - Application displayed:

```
Invalid CSRF Token.
```

---

## Skills Demonstrated

- PHP
- Sessions
- Session Security
- CSRF Protection
- Secure Random Token Generation
- `hash_equals()`
- Secure Coding
- OWASP Top 10

---

## Key Takeaways

- Authentication alone does not protect against CSRF.
- Browsers automatically include session cookies with requests.
- Attackers do not need to steal the session cookie.
- Every state-changing request should be protected with a CSRF token.
- `random_bytes()` provides cryptographically secure token generation.
- `hash_equals()` performs constant-time comparison to reduce the risk of timing attacks.

---

## References

- OWASP Cross-Site Request Forgery Prevention Cheat Sheet
- OWASP Top 10

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and their mitigations. All testing was performed in a controlled lab environment on intentionally vulnerable applications.