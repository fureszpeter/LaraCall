<?php

$ebayConfig = [
    'use_sandbox'   => env('EBAY_SANDBOX', true),
    'default_config' => env('EBAY_CONFIG', 'sandbox'),
    'sandbox'        => [
        'credentials' => [
            'devId'  => env('EBAY_DEV_ID_SANDBOX'),
            'appId'  => env('EBAY_APP_ID_SANDBOX'),
            'certId' => env('EBAY_CERT_ID_SANDBOX'),
        ],
        'authToken'   => env('EBAY_AUTH_TOKEN_SANDBOX'),
    ],
    'production'     => [
        'credentials' => [
            'devId'  => env('EBAY_DEV_ID_PRODUCTION'),
            'appId'  => env('EBAY_APP_ID_PRODUCTION'),
            'certId' => env('EBAY_CERT_ID_PRODUCTION'),
        ],
        'authToken'   => env('EBAY_AUTH_TOKEN_PRODUCTION'),
    ],
];

$currentConfigKey = $ebayConfig['default_config'];

return array_merge($ebayConfig, $ebayConfig[$currentConfigKey]);
