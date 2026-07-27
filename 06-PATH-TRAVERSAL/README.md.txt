# Path Traversal (Directory Traversal)

## Overview

This lab demonstrates a **Path Traversal (Directory Traversal)** vulnerability in a PHP file download application.

The vulnerable implementation allows user-controlled input to determine which file is read from the server. By manipulating the file path using traversal sequences such as `../`, an attacker may access files outside the intended directory.

The secure implementation prevents this by validating the requested file against an allow-list before serving it.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how Path Traversal attacks work.
- Explain why trusting file paths is dangerous.
- Demonstrate directory traversal using `../`.
- Read files outside the intended directory.
- Prevent Path Traversal using input validation and allow-lists.
- Understand secure file handling in PHP.

---

## Lab Structure

```
06-Path-Traversal/
│
├── vulnerable/
│   ├── download.php
│   ├── config.php
│   └── documents/
│
├── secure/
│   ├── download.php
│   ├── config.php
│   └── documents/
│
└── README.md
```

---

## Vulnerability Description

The vulnerable application receives a filename from a URL parameter and appends it directly to the document directory.

Example:

```php
$file = $_GET['file'] ?? '';

$path = "documents/" . $file;

readfile($path);
```

Because the application performs no validation, an attacker can manipulate the path using directory traversal sequences.

---

## Root Cause

The application trusts user-controlled input when building file paths.

Application flow:

1. User supplies a filename.
2. PHP appends it to the documents directory.
3. PHP attempts to read the resulting path.
4. The operating system resolves any `../` sequences.
5. Files outside the intended directory may be disclosed.

---

## Impact

Successful exploitation may allow an attacker to:

- Read configuration files.
- Obtain database credentials.
- Access application source code.
- Read sensitive documents.
- Gather information useful for further attacks.

---

## Vulnerable Code

```php
$file = $_GET['file'] ?? '';

$path = "documents/" . $file;

if (file_exists($path)) {
    readfile($path);
}
```

---

## Secure Approach

The secure implementation validates requested files against an allow-list.

Example:

```php
$allowed = [
    "public.txt",
    "welcome.txt"
];

$file = $_GET['file'] ?? '';

if (!in_array($file, $allowed, true)) {
    exit("Invalid file.");
}

readfile("documents/" . $file);
```

Only approved files can be downloaded.

---

## Testing Performed

### Legitimate Request

```
download.php?file=public.txt
```

Result:

- File downloaded successfully.

---

### Path Traversal Attack

```
download.php?file=../config.php
```

Result:

- Vulnerable version:
    - Configuration file disclosed.

- Secure version:
    - Request rejected.

---

## Skills Demonstrated

- PHP
- File Handling
- Input Validation
- Path Traversal
- Secure Coding
- Manual Security Testing
- OWASP Top 10

---

## Key Takeaways

- Never trust file paths supplied by users.
- The sequence `../` allows navigation outside the intended directory.
- Sensitive files should never be directly accessible.
- An allow-list is one of the safest approaches for downloadable files.
- File access should always be restricted to approved resources.

---

## References

- OWASP Path Traversal
- OWASP Top 10

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and their mitigations. All testing was performed in a controlled lab environment on intentionally vulnerable applications.