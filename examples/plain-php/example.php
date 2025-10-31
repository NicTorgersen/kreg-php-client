<?php

declare(strict_types=1);

/**
 * KREG PHP API - Plain PHP Example
 *
 * This example demonstrates basic usage of the KREG PHP API package
 * in a plain PHP application.
 *
 * Before running this example:
 * 1. Run: composer install
 * 2. Set your KREG credentials as environment variables:
 *    export KREG_SYSTEM_TOKEN="your-system-token"
 *    export KREG_COMPANY_TOKEN="your-company-token"
 * 3. Run: php example.php
 */

require_once __DIR__.'/../../vendor/autoload.php';

use NicTorgersen\KregApiSdk\Exceptions\Kregception;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;
use NicTorgersen\KregApiSdk\Exceptions\KregValidationException;
use NicTorgersen\KregApiSdk\KregClient;
use NicTorgersen\KregApiSdk\KregConfig;

// Helper function to print section headers
function printSection(string $title): void
{
    echo "\n".str_repeat('=', 60)."\n";
    echo $title."\n";
    echo str_repeat('=', 60)."\n\n";
}

// Helper function to print success messages
function printSuccess(string $message): void
{
    echo "✓ {$message}\n";
}

// Helper function to print error messages
function printError(string $message): void
{
    echo "✗ {$message}\n";
}

// Check for required environment variables
$systemToken = getenv('KREG_SYSTEM_TOKEN');
$companyToken = getenv('KREG_COMPANY_TOKEN');

if (! $systemToken || ! $companyToken) {
    printError('Missing required environment variables!');
    echo "\nPlease set the following environment variables:\n";
    echo "  export KREG_SYSTEM_TOKEN=\"your-system-token\"\n";
    echo "  export KREG_COMPANY_TOKEN=\"your-company-token\"\n\n";
    exit(1);
}

// Initialize the KREG client
printSection('Initializing KREG Client');

try {
    $config = KregConfig::make(
        systemToken: $systemToken,
        companyToken: $companyToken,
        baseUrl: getenv('KREG_BASE_URL') ?: 'https://api.kreg.no',
        sessionDuration: 86400, // 24 hours
        timeout: 30
    );

    $client = KregClient::make($config);
    printSuccess('KREG client initialized successfully');
} catch (Exception $e) {
    printError("Failed to initialize client: {$e->getMessage()}");
    exit(1);
}

// Example 1: List Catalog Competences
printSection('Example 1: Listing Catalog Competences');

try {
    $catalogCompetences = $client->catalog()->list();
    printSuccess('Retrieved catalog competences');

    echo "Available competences:\n";
    $count = 0;
    foreach ($catalogCompetences as $competence) {
        echo "  - {$competence->code}: {$competence->name}\n";
        $count++;
        if ($count >= 5) {
            echo '  ... and '.(count($catalogCompetences) - 5)." more\n";
            break;
        }
    }
} catch (Kregception $e) {
    printError("Failed to list catalog competences: {$e->getMessage()}");
}

// Example 2: List Active Companies
printSection('Example 2: Listing Active Companies');

try {
    $companies = $client->companies()->listActive();
    printSuccess('Retrieved active companies');

    echo "Active companies:\n";
    $count = 0;
    foreach ($companies as $company) {
        echo "  - {$company->name} (ID: {$company->id})\n";
        $count++;
        if ($count >= 5) {
            echo '  ... and '.(count($companies) - 5)." more\n";
            break;
        }
    }
} catch (Kregception $e) {
    printError("Failed to list companies: {$e->getMessage()}");
}

// Example 3: Person Management
printSection('Example 3: Person Management');

try {
    // Create a test person
    echo "Creating a test person...\n";
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
    printSuccess("Created person with ID: {$newPerson->id}");

    // Get the person
    echo "\nRetrieving the person...\n";
    $person = $client->person()->get($newPerson->id);
    printSuccess("Retrieved person: {$person->firstName} {$person->lastName}");
    echo "  Email: {$person->email}\n";
    echo "  Phone: {$person->phone}\n";

    // Update the person
    echo "\nUpdating the person...\n";
    $updatedPerson = $client->person()->update(
        id: $newPerson->id,
        email: 'john.doe.updated@example.com'
    );
    printSuccess("Updated person email to: {$updatedPerson->email}");

    // List persons
    echo "\nListing all persons...\n";
    $persons = $client->person()->list();
    printSuccess('Total persons: '.count($persons));

    // Delete the person
    echo "\nDeleting the test person...\n";
    $client->person()->delete($newPerson->id);
    printSuccess("Deleted person with ID: {$newPerson->id}");

} catch (KregNotFoundException $e) {
    printError("Person not found: {$e->getMessage()}");
} catch (KregValidationException $e) {
    printError("Validation error: {$e->getMessage()}");
} catch (Kregception $e) {
    printError("Error managing person: {$e->getMessage()}");
}

// Example 4: Error Handling
printSection('Example 4: Error Handling');

try {
    echo "Attempting to get a non-existent person...\n";
    $client->person()->get(999999);
} catch (KregNotFoundException $e) {
    printSuccess('Correctly caught NotFoundException');
    echo "  Error message: {$e->getMessage()}\n";
    echo "  Error code: {$e->getCode()}\n";
} catch (Kregception $e) {
    printError("Unexpected error: {$e->getMessage()}");
}

// Example 5: Find Person
printSection('Example 5: Finding a Person');

try {
    echo "Searching for a person...\n";
    $foundPerson = $client->person()->find(
        firstName: 'John',
        lastName: 'Doe',
        birthDate: '1990-01-15'
    );

    if ($foundPerson) {
        printSuccess("Found person: {$foundPerson['firstName']} {$foundPerson['lastName']}");
        echo "  ID: {$foundPerson['id']}\n";
    } else {
        echo "  No person found with the given criteria\n";
    }
} catch (Kregception $e) {
    printError("Error finding person: {$e->getMessage()}");
}

// Summary
printSection('Summary');

echo "This example demonstrated:\n";
echo "  ✓ Initializing the KREG client\n";
echo "  ✓ Listing catalog competences\n";
echo "  ✓ Listing active companies\n";
echo "  ✓ Creating, reading, updating, and deleting persons\n";
echo "  ✓ Error handling with specific exception types\n";
echo "  ✓ Finding persons by criteria\n";
echo "\nFor more examples, see the README.md file in this directory.\n\n";
