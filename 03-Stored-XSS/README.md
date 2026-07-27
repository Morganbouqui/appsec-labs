# Stored Cross-Site Scripting (Stored XSS)

## Overview

This lab demonstrates a **Stored Cross-Site Scripting (Stored XSS)** vulnerability in a PHP guestbook application. Unlike Reflected XSS, the malicious payload is permanently stored in the database and executed whenever users visit the affected page.

The secure implementation prevents the vulnerability by encoding user-controlled output with `htmlspecialchars()` before rendering it in the browser.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how Stored XSS works.
- Explain why Stored XSS is more dangerous than Reflected XSS.
- Build a vulnerable PHP guestbook application.
- Safely exploit Stored XSS in a controlled environment.
- Verify the vulnerability across multiple browsers and devices.
- Prevent Stored XSS using proper output encoding.
- Understand the importance of separating SQL Injection prevention from XSS prevention.

---

## Lab Structure

```
03-Stored-XSS/
│
├── vulnerable/
│   ├── db.php
│   ├── index.php
│   └── save.php
│
├── secure/
│   ├── db.php
│   ├── index.php
│   └── save.php
│
└── README.md
```

---

## Vulnerability Description

The vulnerable guestbook stores user input in a database and later displays it without output encoding.

Example:

```php
echo $row['comment'];
```

An attacker can submit malicious JavaScript as a comment. The payload is stored in the database and executed whenever the page displays the stored comment.

---

## Root Cause

The application correctly protects database operations using Prepared Statements but fails to encode untrusted data before rendering it in HTML.

Application flow:

1. User submits a comment.
2. Prepared Statement safely stores the data.
3. The application retrieves the stored comment.
4. The comment is rendered without output encoding.
5. The browser interprets the content as HTML and executes any executable JavaScript.

---

## Impact

Successful exploitation may allow an attacker to:

- Execute arbitrary JavaScript in every visitor's browser.
- Affect multiple users without requiring a malicious link.
- Modify page content.
- Display phishing forms.
- Perform actions as authenticated users.
- Access data available to client-side JavaScript.

Because the payload remains stored until removed, every visitor to the affected page may be impacted.

---

## Mitigation

The secure implementation encodes all user-controlled output before displaying it.

```php
echo "<strong>"
    . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')
    . "</strong><br>";

echo nl2br(
    htmlspecialchars(
        $row['comment'],
        ENT_QUOTES,
        'UTF-8'
    )
);
```

`htmlspecialchars()` converts special HTML characters into HTML entities, preventing the browser from interpreting attacker-controlled input as executable HTML or JavaScript.

`nl2br()` preserves line breaks after the content has been safely encoded.

---

## Testing Performed

The following payloads were tested:

### Normal Comment

```
Hello everyone!
```

Result:

- Successfully stored and displayed.

---

### JavaScript Injection

```html
<script>alert('Stored XSS')</script>
```

Result:

- Vulnerable version: JavaScript executed whenever the page loaded.
- Secure version: Payload displayed as plain text.

---

### Cross-Device Verification

The vulnerable application was tested using:

- Multiple web browsers
- A second computer
- A mobile phone

Result:

- The stored payload executed on every device until the output was properly encoded.

---

## Skills Demonstrated

- PHP
- PDO
- Prepared Statements
- Secure Output Encoding
- Stored Cross-Site Scripting (XSS)
- Secure Coding
- Manual Security Testing
- OWASP Top 10

---

## Key Takeaways

- Prepared Statements prevent SQL Injection but do not prevent XSS.
- Output encoding must be applied when rendering user-controlled data.
- Stored XSS is generally more dangerous than Reflected XSS because it affects every visitor to the affected page.
- Browsers execute JavaScript contained in rendered HTML, not PHP or the database.
- Security controls must be applied at the appropriate stage of the application's data flow.

---

## References

- OWASP Cross Site Scripting Prevention Cheat Sheet
- OWASP Top 10 (A03:2021 – Injection)

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and their mitigations. All testing was performed in a controlled lab environment on intentionally vulnerable applications.
