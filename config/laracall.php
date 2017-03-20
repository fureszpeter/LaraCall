<?php

return [
    'paypal' => [
        /*
         * Drivers: true, false, default
         */
        'ipn_driver' => env('PAYPAL_IPN_DRIVER', 'default'),
    ],
];
