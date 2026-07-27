# DOM-Based Cross-Site Scripting (DOM-Based XSS)

## Overview

This lab demonstrates a **DOM-Based Cross-Site Scripting (DOM-Based XSS)** vulnerability using client-side JavaScript. Unlike Reflected and Stored XSS, the server does not generate the malicious HTML. Instead, the vulnerability occurs entirely within the browser when untrusted user input is inserted into the Document Object Model (DOM) using an unsafe sink such as `innerHTML`.

The secure implementation prevents the vulnerability by replacing `innerHTML` with `textContent`, ensuring user input is treated as plain text instead of HTML.

---

## Learning Objectives

After completing this lab, I was able to:

- Understand how DOM-Based XSS differs from Reflected and Stored XSS.
- Identify sources and sinks in client-side JavaScript.
- Exploit a vulnerable DOM-Based XSS application.
- Understand why `innerHTML` is an unsafe sink.
- Prevent DOM-Based XSS using safe DOM APIs.
- Explain why some payloads execute while others do not.

---

## Lab Structure

```
04-DOM-Based-XSS/
│
├── vulnerable/
│   └── index.html
│
├── secure/
│   └── index.html
│
└── README.md
```

---

## Vulnerability Description

The vulnerable application reads user-controlled input from the URL and inserts it directly into the page using `innerHTML`.

Example:

```javascript
const name = params.get("name") || "Guest";

document.getElementById("welcome").innerHTML =
    "Hello " + name;
```

Because `innerHTML` parses input as HTML, an attacker can inject malicious HTML elements containing JavaScript event handlers.

---

## Root Cause

The application trusts user-controlled input from the URL and inserts it into the DOM using an unsafe sink.

Application flow:

1. User supplies data in the URL.
2. JavaScript reads the value.
3. The value is inserted into the DOM using `innerHTML`.
4. The browser parses the HTML.
5. Malicious HTML or event handlers execute.

Unlike Reflected and Stored XSS, the server is not responsible for generating the malicious HTML response. The vulnerability exists entirely in client-side JavaScript.

---

## Impact

Successful exploitation may allow an attacker to:

- Execute arbitrary JavaScript in the victim's browser.
- Modify page content.
- Display phishing forms.
- Redirect users.
- Perform actions within the user's session.
- Access data available to client-side JavaScript.

---

## Vulnerable Code

```javascript
document.getElementById("welcome").innerHTML =
    "Hello " + name;
```

---

## Secure Code

```javascript
document.getElementById("welcome").textContent =
    "Hello " + name;
```

`textContent` treats user input as plain text instead of HTML, preventing the browser from interpreting attacker-controlled input as executable markup.

---

## Testing Performed

### Normal Input

```
?name=Azeez
```

Result:

- Displayed:

```
Hello Azeez
```

---

### Script Injection

```
?name=<script>alert('DOM XSS')</script>
```

Result:

- Modern browsers generally do not execute `<script>` elements inserted via `innerHTML`.

---

### Event Handler Injection

```html
?name=<img src=x onerror=alert('DOM XSS')>
```

Result:

- Vulnerable version:
  - Browser created the `<img>` element.
  - Image failed to load.
  - `onerror` executed.
  - JavaScript alert displayed.

- Secure version:
  - Payload displayed as plain text.
  - No JavaScript executed.

---

## Security Concepts Learned

### Sources

Untrusted data entered the application from:

- URL parameters (`window.location.search`)

### Unsafe Sink

```javascript
innerHTML
```

### Safe Sink

```javascript
textContent
```

Understanding the flow of data from **source** to **sink** is fundamental when identifying DOM-Based XSS vulnerabilities.

---

## Skills Demonstrated

- JavaScript
- DOM Manipulation
- DOM-Based XSS
- Client-Side Security
- Secure Coding
- Manual Security Testing
- OWASP Top 10

---

## Key Takeaways

- DOM-Based XSS can exist without any server-side vulnerability.
- `innerHTML` is an unsafe sink for untrusted input.
- `textContent` safely renders user input as plain text.
- Browser behavior differs between injected `<script>` elements and HTML elements with executable event handlers.
- Understanding sources and sinks is essential when assessing client-side security.

---

## References

- OWASP Cross Site Scripting Prevention Cheat Sheet
- OWASP DOM Based XSS Prevention Cheat Sheet
- OWASP Top 10 (A03:2021 – Injection)

---

## Disclaimer

This project was created for educational purposes to demonstrate common web application vulnerabilities and their mitigations. All testing was performed in a controlled lab environment on intentionally vulnerable applications.
