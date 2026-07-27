# Insecure Direct Object Reference (IDOR)

## Overview

This project demonstrates an **Insecure Direct Object Reference (IDOR)** vulnerability in a PHP banking application.

The vulnerable version allows authenticated users to access another user's bank statement by modifying the `id` parameter in the URL.

The secure version prevents this by verifying that the requested statement belongs to the currently authenticated user before returning any data.

This lab demonstrates why authentication alone is not sufficient and why proper authorization checks are essential.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand what an IDOR vulnerability is.
- Explain the difference between authentication and authorization.
- Exploit an IDOR vulnerability by modifying URL parameters.
- Implement server-side authorization checks.
- Secure object access using user ownership validation.
- Perform manual security testing for authorization flaws.

---

## Lab Structure

```
07-IDOR/
│
├── vulnerable/
│   ├── database.sql
│   ├── db.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   └── statement.php
│
├── secure/
│   ├── database.sql
│   ├── db.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   └── statement.php
│
└── README.md
```

---

## Vulnerability Description

The application allows users to view bank statements using a URL parameter.

Example:

```
statement.php?id=1
```

The vulnerable application retrieves the requested statement based only on the supplied ID.

Because no ownership verification is performed, an authenticated user can modify the ID to access another customer's information.

---

## Root Cause

The application checks whether a user is logged in but does **not** verify that the requested resource belongs to that user.

Vulnerable SQL:

```php
$stmt = $pdo->prepare("SELECT * FROM statements WHERE id = ?");
$stmt->execute([$id]);
```

This query confirms that the statement exists but ignores ownership.

---

## Impact

Successful exploitation may allow attackers to:

- View another customer's bank statement.
- Access confidential financial information.
- Bypass authorization controls.
- Enumerate sequential object identifiers.
- Expose sensitive personal data.

In real-world applications, IDOR vulnerabilities may expose invoices, medical records, customer profiles, documents, payroll information, or internal business data.

---

## Vulnerable Code

```php
$id = $_GET['id'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM statements WHERE id = ?");
$stmt->execute([$id]);
```

Changing:

```
statement.php?id=1
```

to

```
statement.php?id=2
```

returns another user's bank statement.

---

## Secure Implementation

The secure version validates ownership by checking both the statement ID and the authenticated user's ID.

```php
$stmt = $pdo->prepare("
SELECT *
FROM statements
WHERE id = ?
AND user_id = ?
");

$stmt->execute([
    $id,
    $_SESSION['user_id']
]);
```

Only statements belonging to the logged-in user are returned.

Unauthorized requests are denied.

---

## Testing Performed

### Login

User:

```
alice
```

Password:

```
password123
```

---

### Legitimate Request

```
statement.php?id=1
```

Result:

- Alice successfully views her own statement.

---

### IDOR Attack

Modified request:

```
statement.php?id=2
```

Result (Vulnerable):

- Bob's bank statement is displayed.

Result (Secure):

```
Access denied.
```

The server correctly prevents unauthorized access because the requested statement does not belong to the authenticated user.

---

## Mitigation

IDOR vulnerabilities can be prevented by:

- Performing server-side authorization checks.
- Verifying ownership before returning objects.
- Never trusting user-controlled identifiers.
- Using least-privilege access controls.
- Logging unauthorized access attempts.
- Performing authorization testing during development and security reviews.

---

## Skills Demonstrated

- PHP
- PDO Prepared Statements
- Session Management
- Authentication
- Authorization
- Access Control
- Secure Coding
- Manual Penetration Testing
- OWASP Top 10

---

## Key Takeaways

- Authentication verifies who the user is.
- Authorization determines what the user is allowed to access.
- Never rely solely on object IDs supplied by users.
- Always verify ownership on the server.
- Authorization checks should be performed for every sensitive request.

---

## References

- OWASP Top 10
- OWASP Insecure Direct Object Reference (IDOR)
- OWASP Broken Access Control

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and secure coding practices. All testing was performed in a controlled lab environment on intentionally vulnerable applications.