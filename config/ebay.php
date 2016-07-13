<?php

$ebayConfig = [
    'default_config' => env('EBAY_DEFAULT_CONFIG', 'sandbox'),
    'sandbox'        => [
        'sandbox'   => true,
        'credentials' => [
            'devId'  => env('EBAY_DEV_ID_SANDBOX'),
            'appId'  => env('EBAY_APP_ID_SANDBOX'),
            'certId' => env('EBAY_CERT_ID_SANDBOX'),
        ],
        'authToken'   => env('EBAY_AUTH_TOKEN_SANDBOX'),
        'sellerUser'  => env('EBAY_SELLER_USER_SANDBOX'),
    ],
    'production'     => [
        'sandbox'   => false,
        'credentials' => [
            'devId'  => env('EBAY_DEV_ID_PRODUCTION'),
            'appId'  => env('EBAY_APP_ID_PRODUCTION'),
            'certId' => env('EBAY_CERT_ID_PRODUCTION'),
        ],
        'authToken'   => env('EBAY_AUTH_TOKEN_PRODUCTION'),
        'sellerUser'  => env('EBAY_SELLER_USER_PRODUCTION'),
    ],
];

$currentConfigKey = $ebayConfig['default_config'];

return array_merge($ebayConfig, $ebayConfig[$currentConfigKey]);
