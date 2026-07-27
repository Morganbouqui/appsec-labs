# OS Command Injection

## Overview

This lab demonstrates an **OS Command Injection** vulnerability in a PHP application.

The vulnerable implementation allows user-controlled input to be concatenated directly into an operating system command. An attacker may abuse this by injecting additional shell commands using command separators or other shell metacharacters.

The secure implementation prevents command injection by validating user input against an allow-list and escaping shell arguments before executing the command.

This project demonstrates why user input should never be passed directly to operating system commands without proper validation.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how OS Command Injection occurs.
- Explain why concatenating user input into system commands is dangerous.
- Identify common command injection risks.
- Demonstrate a vulnerable implementation.
- Secure command execution using allow-list validation.
- Apply defence-in-depth when interacting with the operating system.

---

## Lab Structure

```
09-OS-Command-Injection/
│
├── vulnerable/
│   ├── index.php
│   └── ping.php
│
├── secure/
│   ├── index.php
│   └── ping.php
│
└── README.md
```

---

## Vulnerability Description

The vulnerable application accepts a hostname or IP address from the user and directly concatenates it into a system command.

Example:

```php
system("ping -c 4 " . $host);
```

Because no validation is performed, an attacker may attempt to manipulate the command by supplying specially crafted input.

---

## Root Cause

The application trusts user-controlled input when constructing an operating system command.

Application flow:

1. User enters a hostname or IP address.
2. PHP concatenates the input into the command.
3. The operating system interprets the command.
4. Untrusted input reaches the shell.

Without proper validation, this creates an opportunity for command injection.

---

## Impact

Successful exploitation may allow an attacker to:

- Execute unauthorized operating system commands.
- Gather system information.
- Read sensitive files.
- Run additional processes.
- Escalate attacks against the server.

In real-world environments, the impact depends on the privileges of the application and the underlying operating system.

---

## Vulnerable Code

```php
$host = $_GET['host'];

system("ping -c 4 " . $host);
```

The application directly concatenates user input into an operating system command without validation.

---

## Secure Implementation

The secure version applies multiple security controls:

- Allow-list validation.
- Rejects unapproved hosts.
- Uses `escapeshellarg()` before executing the command.
- Accepts only predefined values.

Example:

```php
$allowedHosts = [
    "8.8.8.8",
    "8.8.4.4",
    "1.1.1.1"
];

if (!in_array($host, $allowedHosts, true)) {
    exit("Invalid host.");
}

system("ping -c 4 " . escapeshellarg($host));
```

---

## Testing Performed

### Legitimate Request

Selected host:

```
8.8.8.8
```

Result:

- Ping executes successfully.

---

### Injection Attempt

Example input:

```
8.8.8.8 && whoami
```

Result (Vulnerable):

- The application may execute unintended shell commands if the environment allows it.

Result (Secure):

```
Invalid host.
```

The request is rejected because it is not part of the allow-list.

---

## Mitigation

OS Command Injection can be prevented by:

- Never trusting user input.
- Avoiding shell execution whenever possible.
- Using safer APIs instead of system commands.
- Applying strict allow-list validation.
- Escaping shell arguments when shell execution is necessary.
- Performing server-side validation.

---

## Skills Demonstrated

- PHP
- Secure Coding
- Input Validation
- Allow-list Validation
- Defence in Depth
- Secure Command Execution
- OWASP Top 10

---

## Key Takeaways

- Never concatenate untrusted input into system commands.
- User input must always be validated on the server.
- Avoid invoking a shell whenever possible.
- Use allow-lists for expected values.
- Apply multiple security controls rather than relying on a single defence.

---

## References

- OWASP Command Injection
- OWASP Top 10
- OWASP Input Validation Cheat Sheet

---

## Disclaimer

This project was created for educational purposes to demonstrate OS Command Injection vulnerabilities and secure coding practices. All testing was performed in a controlled lab environment using intentionally vulnerable applications.