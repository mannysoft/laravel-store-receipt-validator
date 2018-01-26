<?php 

namespace Mannysoft\StoreReceiptValidator;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_AndroidPublisher;
use Google_Service_Exception;
use Google_Auth_Exception;

class StoreReceiptValidator {
    

    public function __construct()
    {
        //$this->client = new Client;
    }

    public function validate($store)
    {
        return $store;
    }

}