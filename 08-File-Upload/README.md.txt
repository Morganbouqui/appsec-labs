# Unrestricted File Upload

## Overview

This lab demonstrates an **Unrestricted File Upload** vulnerability in a PHP application.

The vulnerable implementation allows users to upload files without sufficient validation, making it possible for an attacker to upload malicious files that may lead to Remote Code Execution (RCE).

The secure implementation applies multiple layers of validation, including file extension checks, MIME type verification using `finfo`, randomized filenames, upload restrictions, and safe storage practices.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand unrestricted file upload vulnerabilities.
- Explain how attackers bypass client-side validation.
- Validate uploaded files using file extensions and MIME types.
- Generate random filenames for uploaded files.
- Prevent file overwrite attacks.
- Understand why uploads should not be stored inside the web root.
- Apply defence-in-depth when handling file uploads.

---

## Lab Structure

```
08-File-Upload/
│
├── vulnerable/
├── secure/
└── README.md
```

---

## Vulnerability Description

The vulnerable application trusts uploaded files without sufficient validation.

An attacker may upload executable files disguised as images or manipulate file extensions to bypass weak validation.

If the server executes uploaded scripts, this may result in Remote Code Execution.

---

## Root Cause

The application fails to properly validate uploaded files before storing them.

Common mistakes include:

- Trusting client-side validation.
- Validating only file extensions.
- Accepting user-controlled filenames.
- Storing uploads inside the web root.

---

## Impact

Successful exploitation may allow an attacker to:

- Execute arbitrary code.
- Upload web shells.
- Overwrite existing files.
- Host malicious content.
- Compromise the web server.

---

## Secure Implementation

The secure version demonstrates multiple security controls:

- Extension validation.
- MIME type verification using `finfo`.
- Random filenames.
- File size limits.
- Restricted upload directory.
- Defence in depth.

---

## Skills Demonstrated

- PHP
- Secure File Upload
- MIME Type Validation
- File Extension Validation
- Random Filename Generation
- Defence in Depth
- Secure Coding

---

## Key Takeaways

- Never trust client-side validation.
- File extensions alone are insufficient.
- Validate file content using MIME detection.
- Generate random filenames.
- Prevent file overwrite.
- Store uploads securely.
- Apply multiple security controls.

---

## References

- OWASP File Upload Cheat Sheet
- OWASP Top 10

---

## Disclaimer

This project was created for educational purposes in a controlled lab environment.