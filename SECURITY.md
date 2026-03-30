# Security Policy

## Supported Versions

We actively maintain security fixes for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| Latest  | :white_check_mark: |

## Reporting a Vulnerability

**Please do not report security vulnerabilities through public GitHub issues.**

If you discover a security vulnerability in MediVault, please report it by opening a [GitHub Security Advisory](../../security/advisories/new). This allows us to coordinate a fix before public disclosure.

When reporting, please include:

- A description of the vulnerability and its potential impact
- Step-by-step instructions to reproduce the issue
- Any proof-of-concept code or screenshots (if applicable)
- Your suggested fix or mitigation (optional)

We will acknowledge your report within **48 hours** and aim to release a fix within **7 days** for critical issues.

## Disclosure Policy

We follow responsible disclosure practices. Once a fix is released, we will credit the reporter (with their permission) in the release notes.

## Security Best Practices

When deploying MediVault:

- Always set `APP_ENV=production` and `APP_DEBUG=false` in production.
- Use a strong, unique `APP_KEY`.
- Never commit your `.env` file to version control.
- Keep PHP, Laravel, and all dependencies up to date.
- Restrict database and Redis access to trusted hosts only.
- Use HTTPS in production.
