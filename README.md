# Rankify

Rankify is a PHP-based web tool that helps you prioritize options through pairwise comparisons.
Users rank items from predefined card sets. The application calculates scores using different
models (e.g. Thurstone, Bradley–Terry) and presents an ordered list of your preferences.

## Features
* Simple pairwise comparison interface
* Multiple statistical models
* Profile page showing your last results
* Export results as APA text, JSON, PNG or PDF

## Installation
1. Clone the repository.
2. Ensure PHP 8+ is installed.
3. Run a local server with `php -S localhost:8000` in the project directory.
4. Open `http://localhost:8000` in your browser.

No database is required; results are stored locally in the browser.

### Maintenance
Confirmation links generated through the contact form are stored in `data/contact`.
Run `php scripts/cleanup_tokens.php` periodically (e.g. daily via cron) to remove
expired tokens.

## License
This project is released under the MIT License. See `LICENSE` for details.

Fonts are licensed separately under the DejaVu Fonts License. See
`assets/fonts/LICENSE-DejaVu.txt` for the full text.
