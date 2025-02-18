<?php

// config/hdfc.php
return [
    'api_key' => env('HDFC_API_KEY'),
    'merchant_id' => env('HDFC_MERCHANT_ID'),
    'enable_logging' => env('HDFC_ENABLE_LOGGING', false),
    'payment_page_client_id' => env('HDFC_CLIENT_ID'),
    'base_url' => env('HDFC_BASE_URL_TEST'),
    'base_url_production' => env('HDFC_BASE_URL_PRODUCTION'),
    'response_key' => env('HDFC_RESPONSE_KEY'),
];