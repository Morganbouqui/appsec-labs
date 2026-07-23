# SQL Injection

## Objective

The objective of this lab is to understand how SQL Injection occurs, how attackers exploit it, and how to prevent it using secure coding practices in PHP.

---

## What is SQL Injection?

SQL Injection is a web application vulnerability that occurs when untrusted user input is treated as part of an SQL query. This allows an attacker to manipulate the SQL statement and potentially read, modify, or delete data from the database.

---

## Why does it happen?

SQL Injection happens when a developer allows user input to become part of an SQL query instead of keeping user input separate from SQL commands.

The database cannot distinguish between legitimate SQL code and malicious user input when queries are constructed insecurely.

---

## Lab Goal

In this lab I will:

- Build a vulnerable PHP login page.
- Demonstrate how SQL Injection works.
- Fix the vulnerability using Prepared Statements.
- Explain why the secure implementation prevents the attack.

---

> **Key Lesson:** Prepared Statements separate SQL commands from user input, ensuring that user input is always treated as data rather than executable SQL code.


# SQL Injection Lab (PHP & MySQL)

## Overview

This project demonstrates how SQL Injection vulnerabilities occur in PHP applications and how to prevent them using MySQLi Prepared Statements.

The project contains two implementations:

- Vulnerable Login
- Secure Login using Prepared Statements

The purpose of this lab is to understand both the attack and the correct defence.

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

- Understand SQL Injection
- Exploit a vulnerable login page
- Understand why the attack works
- Prevent SQL Injection using Prepared Statements
- Learn the Prepared Statement lifecycle

---

## Vulnerable Login

The vulnerable version builds the SQL query by concatenating user input directly into the SQL statement.

Example:

```php
$sql = "SELECT * FROM users
WHERE username='$username'
AND password='$password'";
```

This allows an attacker to inject SQL commands.

Example payload:

```
' OR '1'='1' --
```

---

## Secure Login

The secure version uses Prepared Statements.

Example:

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

User input is treated as data instead of SQL code.

---

## Lessons Learned

- Never concatenate user input into SQL queries.
- Prepared Statements separate SQL code from user data.
- SQL Injection occurs when user input changes the SQL query structure.
- Prepared Statements prevent SQL Injection by using placeholders and parameter binding.

---

## Repository Structure

```
01-SQL-Injection/
│
├── vulnerable/
│   └── login.php
│
└── secure/
    └── login.php
```

---

## Author

Created as part of my Application Security Engineering learning journey.
