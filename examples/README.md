# KREG PHP API - Examples

This directory contains example implementations of the KREG PHP API package for different use cases.

## Available Examples

### 1. Laravel Application (`example-with-laravel/`)

A complete Laravel application example demonstrating how to integrate the KREG PHP API package into a Laravel project.

**Features:**
- Service provider auto-discovery
- Configuration file with environment variables
- Dependency injection examples
- Error handling in Laravel context
- Testing with Http::fake()

**Quick Start:**
```bash
cd example-with-laravel
composer install
cp .env.example .env
# Edit .env and add your KREG credentials
php artisan serve
```

[View Laravel Example Documentation →](./example-with-laravel/README.md)

### 2. Plain PHP Application (`plain-php/`)

A standalone PHP example showing how to use the KREG PHP API package without any framework.

**Features:**
- Simple, framework-agnostic usage
- Environment variable configuration
- Complete CRUD examples for all resources
- Error handling examples
- Runnable example script

**Quick Start:**
```bash
cd plain-php
composer install
export KREG_SYSTEM_TOKEN="your-system-token"
export KREG_COMPANY_TOKEN="your-company-token"
php example.php
```

[View Plain PHP Example Documentation →](./plain-php/README.md)

## Getting Your KREG Credentials

To use these examples, you'll need:
- **System Token**: Provided by KREG
- **Company Token**: Provided by KREG

Contact KREG support to obtain your API credentials.

## Common Configuration

Both examples use the same configuration parameters:

| Parameter | Description | Default |
|-----------|-------------|---------|
| `KREG_BASE_URL` | KREG API base URL | `https://api.kreg.no` |
| `KREG_SYSTEM_TOKEN` | Your system token | Required |
| `KREG_COMPANY_TOKEN` | Your company token | Required |
| `KREG_SESSION_DURATION` | Session validity in seconds | `86400` (24 hours) |
| `KREG_TIMEOUT` | HTTP request timeout in seconds | `30` |

## Available Resources

All examples demonstrate usage of the following KREG API resources:

- **Person** - Manage persons (create, read, update, delete, find)
- **Competence** - Manage competences for persons
- **Document** - Manage documents for persons
- **Catalog** - Access catalog data (competence types, etc.)
- **Companies** - Manage and list companies

## Error Handling

The package provides specific exception types:

- `KregAuthenticationException` - Authentication failures
- `KregNotFoundException` - Resource not found (404)
- `KregValidationException` - Validation errors
- `Kregception` - General API errors

## Need Help?

- Check the main [README.md](../README.md) for package documentation
- Review the example code in each directory
- See the [KREG API Documentation](../KREG-API-DOCUMENTATION.pdf) for API details

