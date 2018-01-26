<?php 

namespace Mannysoft\StoreReceiptValidator;

class Facade extends \Illuminate\Support\Facades\Facade {
    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'store_receipt_validator';
    }
}