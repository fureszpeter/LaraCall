<?php

$ebayConfig = [
	'sandbox'     => true,
	'credentials' => [
		'devId'  => env('EBAY_DEV_ID_SANDBOX'),
		'appId'  => env('EBAY_APP_ID_SANDBOX'),
		'certId' => env('EBAY_CERT_ID_SANDBOX'),
	],
	'authToken'   => env('EBAY_AUTH_TOKEN_SANDBOX'),
	'sellerUser'  => env('EBAY_SELLER_USER_SANDBOX'),
];

return $ebayConfig;
