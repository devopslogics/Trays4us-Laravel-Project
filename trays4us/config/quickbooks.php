<?php

return [
    // other configurations...
        'client_id' => env('QB_CLIENT_ID'),
        'client_secret' => env('QB_CLIENT_SECRET'),
        'redirect_uri' => env('QB_REDIRECT_URI'),
        'access_token' => env('QB_ACCESS_TOKEN'),
        'refresh_token' => env('QB_REFRESH_TOKEN'),
        'realm_id' => env('QB_REALM_ID'),
        'baseUrl' => env('QUICKBOOKS_BASE_URL'),
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
];
