<?php

$ebayConfig = [
	'sandbox'     => env('EBAY_SANDBOX'),
	'credentials' => [
		'devId'  => env('EBAY_DEV_ID'),
		'appId'  => env('EBAY_APP_ID'),
		'certId' => env('EBAY_CERT_ID'),
	],
	'authToken'   => env('EBAY_AUTH_TOKEN'),
	'sellerUser'  => env('EBAY_SELLER_USER'),
];

return $ebayConfig;
