# Authentication & Session Management

## Overview

This lab demonstrates common authentication and session management vulnerabilities in PHP applications, along with secure coding techniques to mitigate them.

The vulnerable implementation intentionally omits important security controls such as session regeneration, secure password storage, secure cookie settings, and proper logout handling.

The secure implementation follows PHP security best practices by implementing secure password hashing, session regeneration, secure cookie attributes, and complete session destruction during logout.

This project demonstrates how proper authentication and session management significantly reduce the risk of session hijacking and account compromise.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand the difference between authentication and authorization.
- Explain how Session Fixation attacks work.
- Secure user authentication using PHP.
- Hash passwords using `password_hash()`.
- Verify passwords using `password_verify()`.
- Regenerate session identifiers after successful login.
- Configure secure session cookie attributes.
- Implement secure logout functionality.
- Apply defence-in-depth to authentication systems.

---

## Lab Structure

```
10-Authentication-Session-Management/
│
├── vulnerable/
│   ├── users.sql
│   ├── db.php
│   ├── login.php
│   ├── dashboard.php
│   └── logout.php
│
├── secure/
│   ├── users.sql
│   ├── db.php
│   ├── session.php
│   ├── login.php
│   ├── dashboard.php
│   └── logout.php
│
└── README.md
```

---

## Authentication vs Authorization

### Authentication

Authentication answers the question:

> **Who are you?**

It verifies a user's identity using credentials such as a username and password.

---

### Authorization

Authorization answers the question:

> **What are you allowed to do?**

Once authenticated, the application determines which resources and actions the user is permitted to access.

---

## Vulnerability Description

The vulnerable application intentionally demonstrates several common security weaknesses.

These include:

- Plain text password storage.
- No session ID regeneration after login.
- Missing HttpOnly cookie flag.
- Missing Secure cookie flag.
- Missing SameSite cookie attribute.
- Incomplete logout process.

These weaknesses increase the risk of session hijacking and unauthorized account access.

---

## Vulnerable Implementation

The vulnerable version intentionally demonstrates insecure practices including:

### Plain Text Password Storage

Passwords are stored directly in the database.

```php
$password = $_POST['password'];
```

If the database is compromised, every password is immediately exposed.

---

### Missing Session Regeneration

After login, the application continues using the existing session identifier.

```php
session_start();
```

Without calling:

```php
session_regenerate_id(true);
```

the application becomes vulnerable to Session Fixation attacks.

---

### Missing Cookie Security

The session cookie does not enable:

- HttpOnly
- Secure
- SameSite

This increases the attack surface for session theft and cross-site attacks.

---

### Incomplete Logout

Only the session is destroyed.

```php
session_destroy();
```

The browser session cookie may still remain until it expires.

---

## Secure Implementation

The secure version follows modern PHP security practices.

### Password Hashing

Passwords are securely hashed.

```php
password_hash($password, PASSWORD_DEFAULT);
```

Passwords are verified using:

```php
password_verify($password, $hash);
```

---

### Session Regeneration

Immediately after successful authentication:

```php
session_regenerate_id(true);
```

This prevents Session Fixation by assigning the user a new session identifier.

---

### Secure Cookie Configuration

The application enables secure cookie settings including:

- HttpOnly
- Secure (HTTPS)
- SameSite=Lax

These settings help protect session cookies from theft and cross-site attacks.

---

### Secure Logout

During logout the application:

- Clears all session variables.
- Invalidates the session cookie.
- Destroys the session.

This prevents reuse of previous authenticated sessions.

---

## Session Fixation

Session Fixation occurs when an attacker forces a victim to authenticate using a known session identifier.

If the application fails to regenerate the session ID after login, the attacker may reuse that same session identifier after the victim successfully authenticates.

Calling:

```php
session_regenerate_id(true);
```

immediately after successful authentication mitigates this attack.

---

## Testing Performed

### Vulnerable Version

- Logged in successfully.
- Observed that the session identifier remained unchanged after login.
- Verified insecure session handling.

---

### Secure Version

- Logged in successfully.
- Session identifier regenerated after authentication.
- Secure cookie settings applied.
- Session destroyed completely during logout.

---

## Mitigation

Authentication and session management can be strengthened by:

- Hashing passwords using `password_hash()`.
- Verifying passwords using `password_verify()`.
- Regenerating session IDs after login.
- Using HttpOnly cookies.
- Using Secure cookies over HTTPS.
- Applying SameSite cookie protection.
- Destroying sessions completely during logout.
- Performing proper server-side authentication checks.

---

## Skills Demonstrated

- PHP
- Secure Authentication
- Session Management
- Password Hashing
- Session Regeneration
- Secure Cookies
- Secure Logout
- OWASP Top 10
- Secure Coding
- Defence in Depth

---

## Key Takeaways

- Never store passwords in plain text.
- Always hash passwords using modern password hashing functions.
- Regenerate session IDs immediately after successful login.
- Protect session cookies using HttpOnly, Secure, and SameSite attributes.
- Destroy sessions completely during logout.
- Authentication verifies identity.
- Authorization determines access rights.

---

## References

- OWASP Authentication Cheat Sheet
- OWASP Session Management Cheat Sheet
- OWASP Top 10
- PHP Session Security Documentation

---

## Disclaimer

This project was created for educational purposes to demonstrate common authentication and session management vulnerabilities and secure coding practices. All testing was performed in a controlled lab environment using intentionally vulnerable applications.