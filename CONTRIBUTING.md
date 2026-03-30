# Contributing to MediVault

Thank you for considering contributing to MediVault! We welcome bug reports, feature requests, and pull requests.

## Code of Conduct

Please be respectful and constructive in all interactions. We are committed to providing a welcoming environment for everyone.

## Reporting Bugs

Before opening a bug report, please search existing issues to avoid duplicates. When filing a bug, include:

- A clear and descriptive title
- Steps to reproduce the problem
- Expected vs actual behavior
- PHP version, Laravel version, and OS
- Any relevant logs or error messages

## Suggesting Features

Open an issue with the label `enhancement`. Describe the feature, the problem it solves, and any alternatives you considered.

## Pull Requests

1. Fork the repository and create your branch from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Copy the environment file and configure it:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Make your changes and write or update tests as appropriate.

5. Run the test suite to ensure nothing is broken:
   ```bash
   php artisan test
   ```

6. Commit your changes using a clear and descriptive message.

7. Push to your fork and open a pull request against the `main` branch.

## Coding Standards

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards.
- Keep changes focused — one feature or fix per pull request.
- Add PHPDoc blocks for new public methods.

## License

By contributing, you agree that your contributions will be licensed under the project's [MIT License](LICENSE).
