# KREG PHP API - Laravel Example

This example demonstrates how to use the KREG PHP API package in a Laravel application.

## Installation

1. Install the package via Composer:

```bash
composer require nictorgersen/kreg-php-client
```

The service provider will be automatically registered via Laravel's package auto-discovery.

## Configuration

### 1. Publish the Configuration File (Optional)

You can publish the configuration file to customize the settings:

```bash
php artisan vendor:publish --tag=kreg-config
```

This will create a `config/kreg.php` file in your Laravel application.

### 2. Set Environment Variables

Add your KREG credentials to your `.env` file:

```env
KREG_BASE_URL=https://api.kreg.no
KREG_SYSTEM_TOKEN=your-system-token-here
KREG_COMPANY_TOKEN=your-company-token-here
KREG_SESSION_DURATION=86400
KREG_TIMEOUT=30
```

## Usage

### Using the Facade (Recommended)

The package provides a `Kreg` facade that you can use anywhere in your Laravel application:

```php
<?php

namespace App\Http\Controllers;

use Kreg;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        // Use the Kreg facade directly
        $persons = Kreg::person()->list();

        return view('persons.index', ['persons' => $persons]);
    }

    public function store(Request $request)
    {
        // Create a new person using the facade
        $person = Kreg::person()->create(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            birthDate: $request->input('birth_date'),
            email: $request->input('email'),
        );

        return redirect()->route('persons.show', $person->id);
    }

    public function show(int $id)
    {
        $person = Kreg::person()->get($id);

        return view('persons.show', ['person' => $person]);
    }

    public function update(Request $request, int $id)
    {
        $person = Kreg::person()->update(
            id: $id,
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        return redirect()->route('persons.show', $person->id);
    }

    public function destroy(int $id)
    {
        Kreg::person()->delete($id);

        return redirect()->route('persons.index');
    }
}
```

### Alternative: Direct Client Usage

If you prefer not to use the facade, you can also inject the client directly:

```php
<?php

namespace App\Http\Controllers;

use NicTorgersen\KregApiSdk\KregClient;

class PersonController extends Controller
{
    public function __construct(
        private KregClient $kreg
    ) {}

    public function index()
    {
        $persons = $this->kreg->person()->list();

        return view('persons.index', ['persons' => $persons]);
    }
}
```

### Working with All Resources

The `Kreg` facade provides access to all KREG API resources:

```php
<?php

use Kreg;

// Person resource
$persons = Kreg::person()->list();
$person = Kreg::person()->get($id);
$person = Kreg::person()->create(...);
$person = Kreg::person()->update(...);
Kreg::person()->delete($id);

// Competence resource
$competences = Kreg::competence()->list(personId: $personId);
$competence = Kreg::competence()->get($id);
$competence = Kreg::competence()->create(...);
$competence = Kreg::competence()->update(...);
Kreg::competence()->delete($id);

// Document resource
$documents = Kreg::document()->list(personId: $personId);
$document = Kreg::document()->get($id);
$document = Kreg::document()->create(...);
Kreg::document()->delete($id);

// Catalog resource
$catalogCompetences = Kreg::catalog()->list();

// Companies resource
$companies = Kreg::companies()->listActive();
```

## Available Resources

The `Kreg` facade provides access to the following resources:

- **Person**: `Kreg::person()` - Manage persons
- **Competence**: `Kreg::competence()` - Manage competences
- **Document**: `Kreg::document()` - Manage documents
- **Catalog**: `Kreg::catalog()` - Access catalog data
- **Companies**: `Kreg::companies()` - Manage companies

## Error Handling

The package throws specific exceptions for different error types:

```php
use Kreg;
use NicTorgersen\KregApiSdk\Exceptions\KregAuthenticationException;
use NicTorgersen\KregApiSdk\Exceptions\KregNotFoundException;
use NicTorgersen\KregApiSdk\Exceptions\KregValidationException;
use NicTorgersen\KregApiSdk\Exceptions\Kregception;

try {
    $person = Kreg::person()->get($personId);
} catch (KregNotFoundException $e) {
    // Person not found
    return response()->json(['error' => 'Person not found'], 404);
} catch (KregAuthenticationException $e) {
    // Authentication failed
    return response()->json(['error' => 'Authentication failed'], 401);
} catch (KregValidationException $e) {
    // Validation error
    return response()->json(['error' => $e->getMessage()], 422);
} catch (Kregception $e) {
    // General KREG API error
    return response()->json(['error' => $e->getMessage()], 500);
}
```

## Testing

When testing your Laravel application, you can use Laravel's `Http::fake()` to mock KREG API responses:

```php
<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    public function test_can_list_persons()
    {
        Http::fake([
            '*/KR_Session' => [
                'sessionId' => 'test-session-id',
                'result' => ['code' => 0, 'detailed' => ''],
            ],
            '*/KR_Person_List' => [
                'persons' => [
                    ['id' => 1, 'firstName' => 'John', 'lastName' => 'Doe'],
                    ['id' => 2, 'firstName' => 'Jane', 'lastName' => 'Smith'],
                ],
                'result' => ['code' => 0, 'detailed' => ''],
            ],
        ]);

        $response = $this->get('/persons');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Jane Smith');
    }
}
```
