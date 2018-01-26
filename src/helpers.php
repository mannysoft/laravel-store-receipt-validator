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
    
    function store_receipt_validate()
    {
        return store_receipt()->validate();
    }
}