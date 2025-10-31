<?php

return [
    /*
    |--------------------------------------------------------------------------
    | KREG API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the KREG API. This should be the root URL without
    | any trailing slashes.
    |
    */
    'base_url' => env('KREG_BASE_URL', 'https://api.kreg.no'),

    /*
    |--------------------------------------------------------------------------
    | System Token
    |--------------------------------------------------------------------------
    |
    | Your KREG system token. This is provided by KREG and is used for
    | authentication along with the company token.
    |
    */
    'system_token' => env('KREG_SYSTEM_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Company Token
    |--------------------------------------------------------------------------
    |
    | Your KREG company token. This is provided by KREG and is used for
    | authentication along with the system token.
    |
    */
    'company_token' => env('KREG_COMPANY_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Session Duration
    |--------------------------------------------------------------------------
    |
    | The duration (in seconds) that a KREG session is valid. Default is
    | 24 hours (86400 seconds). Sessions will be automatically renewed
    | when they expire.
    |
    */
    'session_duration' => env('KREG_SESSION_DURATION', 86400),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout (in seconds) for HTTP requests to the KREG API.
    |
    */
    'timeout' => env('KREG_TIMEOUT', 30),
];
