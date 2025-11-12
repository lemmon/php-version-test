# PHP Version Test

Small PHP version check tool that shows differences between webserver and CLI or Composer contexts.

## Usage
1. Run `composer run build` to record the CLI environments (`php` and `@php`).
2. Serve the project (e.g., `php -S localhost:8000`) and open `index.php` to compare the server runtime with the stored CLI data.
