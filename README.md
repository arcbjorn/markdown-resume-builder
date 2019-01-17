# Markdown Resume Builder

Convert markdown-formatted resumes to styled HTML and PDF.

## Features

- Parse markdown to HTML resume
- Multiple professional themes
- Export to PDF
- Custom CSS styling
- CLI command support

## Usage

```bash
php artisan resume:build resume.md --theme=professional
php artisan resume:export resume.md --format=pdf
```

## Markdown Format

```markdown
# John Doe
**Email:** john@example.com | **Phone:** 555-1234

## Experience
### Senior Developer | Company (2018-Present)
- Achievement 1
- Achievement 2

## Skills
- PHP, Laravel, JavaScript
```

## Requirements

- PHP 7.2+
- Laravel 5.8
