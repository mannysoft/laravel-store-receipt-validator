<?php

return [
    'store_environment' => env('STORE_ENVIRONMENT', 'production'),
    'apple_verify_receipt' => env('APPLE_VERIFY_RECEIPT', 'https://buy.itunes.apple.com/verifyReceipt'),
    'apple_verify_password' => env('APPLE_VERIFY_PASSWORD', null),

    'android_credentials_path' => env('ANDROID_CREDENTIALS_PATH', storage_path('app/android_credentials.json')),
    'android_scopes' => [
    	'https://www.googleapis.com/auth/androidpublisher'
   	],

    // https://buy.itunes.apple.com/verifyReceipt
    // https://sandbox.itunes.apple.com/verifyReceipt
];