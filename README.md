# KREG PHP API

A modern PHP wrapper for the KREG API (Norwegian competence registry system) built with Laravel's HTTP client.

## Features

- 🚀 **Laravel Integration** - Service provider, facade, and auto-discovery
- 🔒 **Session Management** - Automatic session handling with SHA-256 authentication
- 📦 **Resource-Based API** - Clean, intuitive interface for all KREG resources
- ✅ **Fully Tested** - Comprehensive test suite with Pest
- 🎯 **Type-Safe** - PHP 8.2+ with readonly properties and strict types
- 🔄 **Laravel 10, 11, 12** - Full support for all modern Laravel versions

## Installation

Install via Composer:

```bash
composer require nictorgersen/kreg-php-client
```

## Quick Start

### Laravel

The package auto-registers in Laravel. Just publish the config and start using the facade:

```bash
php artisan vendor:publish --tag="kreg-config"
```

Configure your credentials in `.env`:

```env
KREG_SYSTEM_TOKEN=your-system-token
KREG_COMPANY_TOKEN=your-company-token
```

Use the facade:

```php
use NicTorgersen\KregApiSdk\Facades\Kreg;

// List persons
$persons = Kreg::person()->list();

// Create a person
$person = Kreg::person()->create(
    firstName: 'John',
    lastName: 'Doe',
    birthDate: '1990-01-01'
);

// Manage competences
$competence = Kreg::competence()->create(
    personId: $person->id,
    competenceId: 123,
    validFrom: '2024-01-01',
    validTo: '2025-01-01'
);
```

### Plain PHP

```php
use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;

$config = KregConfig::make(
    systemToken: 'your-system-token',
    companyToken: 'your-company-token'
);

$client = KregClient::make($config);

// Use the client
$persons = $client->person()->list();
```

## Available Resources

The package provides access to all KREG API resources:

- **Person** - Manage persons (create, read, update, delete, find)
- **Competence** - Manage competences for persons
- **Document** - Manage documents for persons
- **Catalog** - Access catalog data (competence types, etc.)
- **Companies** - Manage and list companies

## Examples

Comprehensive examples are available in the [`examples/`](./examples) directory:

- **[Laravel Example](./examples/example-with-laravel)** - Complete Laravel integration with facade usage, dependency injection, and testing
- **[Plain PHP Example](./examples/plain-php)** - Framework-agnostic usage with runnable examples

## Requirements

- PHP 8.2 or higher
- Laravel 10.x, 11.x, or 12.x (for Laravel integration)

## Testing

Run the test suite:

```bash
composer test
```

Format code with Laravel Pint:

```bash
composer format
```

## Configuration

The package uses the following configuration options:

| Option | Description | Default |
|--------|-------------|---------|
| `system_token` | Your KREG system token | Required |
| `company_token` | Your KREG company token | Required |
| `base_url` | KREG API base URL | `https://kreg.sr.no/kreg/v1/` |
| `session_duration` | Session validity in seconds | `86400` (24 hours) |
| `timeout` | HTTP request timeout in seconds | `30` |

## Error Handling

The package provides specific exception types:

```php
use NicTorgersen\KregApiSdk\Exceptions\Kregception;
use NicTorgersen\KregApiSdk\Exceptions\KregAuthenticationException;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;
use NicTorgersen\KregApiSdk\Exceptions\KregValidationException;

try {
    $person = Kreg::person()->get($id);
} catch (KregNotFoundException $e) {
    // Person not found
} catch (KregAuthenticationException $e) {
    // Authentication failed
} catch (KregValidationException $e) {
    // Validation error
} catch (Kregception $e) {
    // General API error
}
```

## License

MIT

## Credits

- [Nichlas Torgersen](https://github.com/nictorgersen)

## Support

For issues or questions, please use the [GitHub issue tracker](https://github.com/nictorgersen/kreg-php-client/issues).

