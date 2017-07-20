<?php 

namespace Mannysoft\StoreReceiptValidator;

use ReceiptValidator\iTunes\Validator as iTunesValidator;
use ReceiptValidator\GooglePlay\Validator as PlayValidator;

use ReceiptValidator\Amazon\Validator as AmazonValidator;
use ReceiptValidator\Amazon\Response as ValidatorResponse;

class StoreReceiptValidator {

    public function __construct()
    {
        
    }

    public function apple($request = null)
    {
        $validator = new iTunesValidator(iTunesValidator::ENDPOINT_PRODUCTION);
        
        $receiptBase64Data = $request->input('receipt-data');
        
        try {
          $response = $validator->setReceiptData($receiptBase64Data)->validate();
        } catch (Exception $e) {
          echo 'got error = ' . $e->getMessage() . PHP_EOL;
        }

        if ($response->isValid()) {
          echo 'Receipt is valid.' . PHP_EOL;
          echo 'Receipt data = ' . print_r($response->getReceipt()) . PHP_EOL;
        } else {
          echo 'Receipt is not valid.' . PHP_EOL;
          echo 'Receipt result code = ' . $response->getResultCode() . PHP_EOL;
        }
        
    }
    
    public function google($request = null)
    {
        googleClient = new \Google_Client();
        $googleClient->setScopes([\Google_Service_AndroidPublisher::ANDROIDPUBLISHER]);
        $googleClient->setApplicationName('Fax');
        $googleClient->setAuthConfig(storage_path('app/android_credentials.json'));

        $googleAndroidPublisher = new \Google_Service_AndroidPublisher($googleClient);
        $validator = new \ReceiptValidator\GooglePlay\Validator($googleAndroidPublisher);

        try {
          $response = $validator->setPackageName('PACKAGE_NAME')
              ->setProductId('PRODUCT_ID')
              ->setPurchaseToken('PURCHASE_TOKEN')
              ->validateSubscription();
        } catch (\Exception $e){
          var_dump($e->getMessage());
          // example message: Error calling GET ....: (404) Product not found for this application.
        }
        // success
        // Get the value of response
        
    }
}