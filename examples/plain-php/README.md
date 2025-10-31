# KREG PHP API - Plain PHP Example

This example demonstrates how to use the KREG PHP API package in a plain PHP application (without Laravel).

## Installation

1. Install the package via Composer:

```bash
composer require nictorgersen/kreg-php-client
```

## Setup

Create a simple PHP file to use the KREG API:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;

// Configure the client
$config = KregConfig::make(
    systemToken: 'your-system-token-here',
    companyToken: 'your-company-token-here',
    baseUrl: 'https://api.kreg.no',
    sessionDuration: 86400, // 24 hours
    timeout: 30
);

// Create the client
$client = KregClient::make($config);

// Now you can use the client
try {
    // List all persons
    $persons = $client->person()->list();
    
    foreach ($persons as $person) {
        echo "Person: {$person['firstName']} {$person['lastName']}\n";
    }
} catch (Kregception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Complete Examples

### Example 1: Managing Persons

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;

// Initialize client
$client = KregClient::make(
    KregConfig::make(
        systemToken: getenv('KREG_SYSTEM_TOKEN'),
        companyToken: getenv('KREG_COMPANY_TOKEN'),
    )
);

// Create a new person
try {
    $newPerson = $client->person()->create(
        firstName: 'John',
        lastName: 'Doe',
        birthDate: '1990-01-15',
        email: 'john.doe@example.com',
        phone: '+4712345678',
        address: 'Main Street 123',
        postalCode: '0123',
        city: 'Oslo'
    );
    
    echo "Created person with ID: {$newPerson->id}\n";
    
    // Get the person
    $person = $client->person()->get($newPerson->id);
    echo "Retrieved person: {$person->firstName} {$person->lastName}\n";
    
    // Update the person
    $updatedPerson = $client->person()->update(
        id: $newPerson->id,
        email: 'john.doe.updated@example.com'
    );
    echo "Updated person email to: {$updatedPerson->email}\n";
    
    // Find a person
    $foundPerson = $client->person()->find(
        firstName: 'John',
        lastName: 'Doe',
        birthDate: '1990-01-15'
    );
    
    if ($foundPerson) {
        echo "Found person: {$foundPerson['firstName']} {$foundPerson['lastName']}\n";
    }
    
    // List all persons
    $persons = $client->person()->list();
    echo "Total persons: " . count($persons) . "\n";
    
    // Delete the person
    $client->person()->delete($newPerson->id);
    echo "Deleted person with ID: {$newPerson->id}\n";
    
} catch (KregNotFoundException $e) {
    echo "Not found: {$e->getMessage()}\n";
} catch (Kregception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

### Example 2: Managing Competences

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;

// Initialize client
$client = KregClient::make(
    KregConfig::make(
        systemToken: getenv('KREG_SYSTEM_TOKEN'),
        companyToken: getenv('KREG_COMPANY_TOKEN'),
    )
);

try {
    // Create a competence
    $competence = $client->competence()->create(
        personId: 123,
        competenceCode: 'COMP001',
        validFrom: '2024-01-01',
        validTo: '2025-12-31'
    );
    
    echo "Created competence with ID: {$competence->id}\n";
    
    // Get the competence
    $retrievedCompetence = $client->competence()->get($competence->id);
    echo "Competence code: {$retrievedCompetence->competenceCode}\n";
    
    // List competences for a person
    $competences = $client->competence()->list(personId: 123);
    echo "Person has " . count($competences) . " competences\n";
    
    // Update competence
    $updatedCompetence = $client->competence()->update(
        id: $competence->id,
        validTo: '2026-12-31'
    );
    echo "Updated competence valid to: {$updatedCompetence->validTo}\n";
    
    // Delete competence
    $client->competence()->delete($competence->id);
    echo "Deleted competence\n";
    
} catch (Kregception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

### Example 3: Managing Documents

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;

// Initialize client
$client = KregClient::make(
    KregConfig::make(
        systemToken: getenv('KREG_SYSTEM_TOKEN'),
        companyToken: getenv('KREG_COMPANY_TOKEN'),
    )
);

try {
    // Create a document
    $document = $client->document()->create(
        personId: 123,
        documentType: 'certificate',
        title: 'Safety Certificate',
        description: 'Annual safety training certificate',
        fileContent: base64_encode(file_get_contents('certificate.pdf')),
        fileName: 'certificate.pdf',
        mimeType: 'application/pdf'
    );
    
    echo "Created document with ID: {$document->id}\n";
    
    // Get the document
    $retrievedDocument = $client->document()->get($document->id);
    echo "Document title: {$retrievedDocument->title}\n";
    
    // List documents for a person
    $documents = $client->document()->list(personId: 123);
    echo "Person has " . count($documents) . " documents\n";
    
    // Delete document
    $client->document()->delete($document->id);
    echo "Deleted document\n";
    
} catch (Kregception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

### Example 4: Using Catalog and Companies

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;

// Initialize client
$client = KregClient::make(
    KregConfig::make(
        systemToken: getenv('KREG_SYSTEM_TOKEN'),
        companyToken: getenv('KREG_COMPANY_TOKEN'),
    )
);

try {
    // List catalog competences
    $catalogCompetences = $client->catalog()->list();
    
    echo "Available competences in catalog:\n";
    foreach ($catalogCompetences as $competence) {
        echo "- {$competence->code}: {$competence->name}\n";
    }
    
    // List active companies
    $companies = $client->companies()->listActive();
    
    echo "\nActive companies:\n";
    foreach ($companies as $company) {
        echo "- {$company->name} (ID: {$company->id})\n";
    }
    
} catch (Kregception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

## Error Handling

The package provides specific exception types for different errors:

```php
<?php

use NicTorgersen\KregApiSdk\Exceptions\KregAuthenticationException;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;
use NicTorgersen\KregApiSdk\Exceptions\KregValidationException;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;

try {
    $person = $client->person()->get($personId);
} catch (KregNotFoundException $e) {
    // Handle not found (404)
    echo "Resource not found: {$e->getMessage()}\n";
    echo "Error code: {$e->getCode()}\n";
} catch (KregAuthenticationException $e) {
    // Handle authentication errors
    echo "Authentication failed: {$e->getMessage()}\n";
} catch (KregValidationException $e) {
    // Handle validation errors
    echo "Validation error: {$e->getMessage()}\n";
} catch (Kregception $e) {
    // Handle general KREG API errors
    echo "API error: {$e->getMessage()}\n";
    echo "Error code: {$e->getCode()}\n";
}
```

## Environment Variables

For security, it's recommended to use environment variables for your credentials. You can use a `.env` file with a library like `vlucas/phpdotenv`:

```bash
composer require vlucas/phpdotenv
```

Then create a `.env` file:

```env
KREG_SYSTEM_TOKEN=your-system-token-here
KREG_COMPANY_TOKEN=your-company-token-here
KREG_BASE_URL=https://api.kreg.no
```

And load it in your PHP file:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Use environment variables
$client = KregClient::make(
    KregConfig::make(
        systemToken: $_ENV['KREG_SYSTEM_TOKEN'],
        companyToken: $_ENV['KREG_COMPANY_TOKEN'],
        baseUrl: $_ENV['KREG_BASE_URL'] ?? 'https://api.kreg.no',
    )
);
```

## Session Management

The KREG client automatically manages sessions for you:

- Sessions are created automatically on the first API call
- Sessions are reused for subsequent calls
- Sessions are automatically renewed when they expire (default: 24 hours)
- You don't need to manually manage session creation or renewal

```php
<?php

// The client handles sessions automatically
$client = KregClient::make($config);

// First call creates a session
$persons = $client->person()->list();

// Subsequent calls reuse the same session
$competences = $client->competence()->list();

// After 24 hours, the session is automatically renewed
$documents = $client->document()->list();
```

