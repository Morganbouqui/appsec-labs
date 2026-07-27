# Reflected Cross-Site Scripting (Reflected XSS)

## Overview

This lab demonstrates a **Reflected Cross-Site Scripting (XSS)** vulnerability in a PHP application. The vulnerable implementation reflects untrusted user input directly into the HTML response without output encoding, allowing malicious JavaScript to execute in the victim's browser.

The secure implementation mitigates the vulnerability by encoding user-controlled data with `htmlspecialchars()` before rendering it in the browser.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how Reflected XSS works.
- Identify unsafe handling of user input.
- Exploit a vulnerable PHP application safely.
- Explain why browsers execute injected JavaScript.
- Prevent Reflected XSS using output encoding.
- Understand the difference between SQL Injection mitigation and XSS mitigation.

---

## Lab Structure

```
02-Reflected-XSS/
│
├── vulnerable/
│   └── index.php
│
├── secure/
│   └── index.php
│
└── README.md
```

---

## Vulnerability Description

The vulnerable application reads user input from the URL and inserts it directly into the HTML response.

Example:

```php
echo "<h3>Hello " . $_GET['name'] . "</h3>";
```

Because the application trusts user-controlled input, an attacker can inject HTML or JavaScript that the browser interprets as part of the page.

---

## Root Cause

The application outputs untrusted user input directly into HTML without encoding.

The vulnerability is **not** caused by PHP executing JavaScript.

Instead:

1. PHP generates the HTML response.
2. The browser receives the HTML.
3. The browser parses the HTML.
4. The browser executes any executable JavaScript contained in the page.

---

## Impact

Successful exploitation may allow an attacker to:

- Execute arbitrary JavaScript in the victim's browser.
- Modify page content.
- Redirect users.
- Display fake login forms.
- Perform actions as the authenticated user.
- Access data available to client-side JavaScript.

---

## Mitigation

The secure implementation encodes user-controlled output before rendering it.

```php
echo "<h3>Hello "
    . htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES, 'UTF-8')
    . "</h3>";
```

Encoding special HTML characters prevents the browser from interpreting attacker-controlled input as executable HTML or JavaScript.

---

## Testing Performed

The following payloads were tested:

### HTML Injection

```html
<h1>I Hacked This Page</h1>
```

Result:

- Vulnerable version: Rendered as HTML.
- Secure version: Displayed as plain text.

### JavaScript Injection

```html
<script>alert('Reflected XSS')</script>
```

Result:

- Vulnerable version: JavaScript executed.
- Secure version: Displayed as plain text.

---

## Skills Demonstrated

- PHP
- Secure Output Encoding
- Cross-Site Scripting (XSS)
- Vulnerability Analysis
- Secure Coding
- Manual Security Testing
- OWASP Top 10

---

## Key Takeaways

- User input should never be trusted.
- Prepared Statements prevent SQL Injection, **not** XSS.
- XSS prevention is achieved through context-appropriate output encoding.
- The browser executes injected JavaScript, not PHP.
- `htmlspecialchars()` is an effective mitigation for HTML output contexts.

---

## References

- OWASP Cross Site Scripting Prevention Cheat Sheet
- OWASP Top 10 (A03:2021 – Injection)

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and their mitigations. All testing was performed in a controlled lab environment on applications intentionally built for security training.
