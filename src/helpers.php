<?php

if (!function_exists('store_receipt')) {
    /**
     * Get the StoreReceiptValidator instance
     *
     * @return \Mannysoft\StoreReceiptValidator\StoreReceiptValidator
     */
    function store_receipt()
    {
        return app(\Mannysoft\StoreReceiptValidator\StoreReceiptValidator::class);
    }
}

if (!function_exists('store_receipt_validate')) {
    
    function store_receipt_validate($store = 'ios')
    {
        return store_receipt()->validate($store);
    }
}

if (!function_exists('store_receipt_data')) {
    
    function store_receipt_data()
    {
        return store_receipt()->getData();
    }
}