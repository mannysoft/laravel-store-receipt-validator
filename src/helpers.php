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
    
    function store_receipt_validate($store = 'ios', $data = null)
    {
        return store_receipt()->validate($store, $data);
    }
}

if (!function_exists('store_validate_subscription')) {
    
    function store_validate_subscription($store = 'ios', $data = null)
    {
        return store_receipt()->validate($store, $data);
    }
}

if (!function_exists('store_receipt_data')) {
    
    function store_receipt_data()
    {
        return store_receipt()->getData();
    }
}

if (!function_exists('store_status_update')) {
    
    function store_status_update($store = 'ios', $data = null)
    {
        return store_receipt()->statusUpdateNotification($store, $data);
    }
}