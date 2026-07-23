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
