# SQL Injection Lab (PHP & MySQL)

## Overview

This project demonstrates how SQL Injection vulnerabilities occur in PHP applications and how to prevent them using **MySQLi Prepared Statements**.

The purpose of this lab is to understand:

- How SQL Injection works
- Why insecure SQL queries are dangerous
- How attackers exploit vulnerable login forms
- How Prepared Statements prevent SQL Injection

This lab contains both a **vulnerable** and a **secure** implementation so the difference between insecure and secure coding practices can be clearly understood.

---

## Objective

The objective of this lab is to gain practical experience with one of the most common web application vulnerabilities by:

- Building a vulnerable PHP login page
- Demonstrating a SQL Injection attack
- Fixing the vulnerability using Prepared Statements
- Understanding why the secure implementation works

---

## What is SQL Injection?

SQL Injection is a web application vulnerability that occurs when untrusted user input is treated as part of an SQL query.

Instead of being treated as ordinary data, malicious input becomes executable SQL commands, allowing attackers to manipulate database queries.

Successful SQL Injection attacks may allow an attacker to:

- Bypass authentication
- Read sensitive data
- Modify records
- Delete information
- Execute unintended database operations

---

## Why does SQL Injection happen?

SQL Injection occurs when developers concatenate user input directly into SQL queries.

Example of vulnerable code:

```php
$sql = "SELECT * FROM users
WHERE username='$username'
AND password='$password'";
```

Because user input becomes part of the SQL statement itself, the database cannot distinguish between legitimate SQL commands and malicious input.

---

## Technologies Used

- PHP
- MySQL
- MySQLi
- HTML
- Git
- GitHub

---

## Learning Objectives

After completing this lab I learned how to:

- Understand SQL Injection attacks
- Build a vulnerable PHP login page
- Exploit SQL Injection for educational purposes
- Prevent SQL Injection using Prepared Statements
- Understand the Prepared Statement lifecycle
- Write more secure database queries

---

## Repository Structure

```
01-SQL-Injection/
│
├── README.md
│
├── vulnerable/
│   └── login.php
│
└── secure/
    └── login.php
```

---

# Vulnerable Implementation

The vulnerable login page directly inserts user input into an SQL query.

```php
$sql = "SELECT * FROM users
WHERE username='$username'
AND password='$password'";
```

This allows attackers to change the structure of the SQL query.

---

## Example SQL Injection Payload

```
' OR '1'='1' --
```

Instead of checking for a valid username, the SQL statement becomes true for every record, allowing authentication to be bypassed.

---

# Secure Implementation

The secure version uses MySQLi Prepared Statements.

```php
$stmt = $conn->prepare(
"SELECT * FROM users
WHERE username = ?
AND password = ?"
);

$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();
```

Instead of inserting user input into the SQL query, the values are bound separately as parameters.

The SQL structure never changes, even if an attacker submits malicious input.

---

## Why Prepared Statements Prevent SQL Injection

Prepared Statements separate:

- SQL commands
- User input

The SQL statement is prepared first.

User values are then bound to placeholders (`?`) and sent separately to the database.

Because the database always treats the bound values as data rather than SQL code, injected SQL commands cannot alter the query structure.

---

## Vulnerable vs Secure

| Vulnerable | Secure |
|------------|--------|
| User input becomes part of SQL | User input is bound separately |
| SQL query can be modified | SQL structure cannot change |
| Vulnerable to SQL Injection | Protected against SQL Injection |
| Uses string concatenation | Uses Prepared Statements |

---

## Lessons Learned

- Never concatenate user input into SQL queries.
- User input should always be treated as untrusted.
- Prepared Statements separate SQL commands from user data.
- SQL Injection occurs when user input changes the SQL query structure.
- Prepared Statements prevent SQL Injection by using placeholders and parameter binding.

---

## Skills Demonstrated

- PHP Development
- MySQL Database Queries
- MySQLi Prepared Statements
- Secure Coding Practices
- SQL Injection Prevention
- Application Security Fundamentals
- Git Version Control
- GitHub Documentation

---

## Future Improvements

Possible enhancements for this project include:

- Password hashing using `password_hash()`
- Password verification using `password_verify()`
- CSRF protection
- Session management
- Login rate limiting
- Account lockout after repeated failed logins
- Logging failed login attempts

---

## OWASP Reference

This lab relates to the **OWASP Top 10** category:

**A03:2021 – Injection**

---

## Author

Created as part of my journey to become an **Application Security Engineer**, focusing on hands-on PHP security labs and secure coding practices.
