<?php 

namespace Mannysoft\StoreReceiptValidator;

use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_AndroidPublisher;
use Google_Service_Exception;
use Google_Auth_Exception;
use Mannysoft\StoreReceiptValidator\StoreInterface;

class Android implements StoreInterface {
	
	public $verified = false;
	public $result = null;

	public $androidApplicationName = 'App';

	public function validatePurchase($requestData)
	{
		try {
            // Create new Google Client
            $client = new Google_Client();
            // Set Application Name to the name of the mobile app
            //$client->setApplicationName($this->androidApplicationName);
            $client->setApplicationName('Fax app - Receive Fax on Android');
         
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . config('store_validator.android_credentials_path'));
            $client->useApplicationDefaultCredentials();
            $client->setScopes(config('store_validator.android_scopes'));
         	
            // Create a new Android Publisher service class
            $service = new Google_Service_AndroidPublisher($client);

            $receipt = $requestData['receipts'];

            try {
                $product = $service->purchases_products->get(
                		$receipt['packageName'],
                		$receipt['productId'],
                		$receipt['purchaseToken']
                );

                if ($product) {
                	$this->verified = true;
                	$this->result = $product;
                }
            } catch (Google_Service_Exception $e) {
                return false;
            }

        } catch (Google_Auth_Exception $e) {
            // if the call to Google fails, throw an exception
            //throw new Exception('Error validating transaction', 500);
            return false;
        }

        return $this;
	}

	public function validateSubscription($requestData)
	{
		try {
            // Create new Google Client
            $client = new Google_Client();
            // Set Application Name to the name of the mobile app
            //$client->setApplicationName($this->androidApplicationName);

            $client->setApplicationName('Fax app - Receive Fax on Android');
            // Fax app - Receive Fax on Android
         
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . config('store_validator.android_credentials_path'));
            $client->useApplicationDefaultCredentials();
            $client->setScopes(config('store_validator.android_scopes'));
         	
            // Create a new Android Publisher service class
            $service = new Google_Service_AndroidPublisher($client);

            $receipt = $requestData['receipts'];

            try {
                $product = $service->purchases_subscriptions->get(
                		$receipt['packageName'],
                		$receipt['subscriptionId'],
                		$receipt['purchaseToken']
                );

                if ($product) {
                	$this->verified = true;
                	return $product;
                }
            } catch (Google_Service_Exception $e) {
                return false;
            }

        } catch (Google_Auth_Exception $e) {
            // if the call to Google fails, throw an exception
            //throw new Exception('Error validating transaction', 500);
            return false;
        }

        return $this;
	}

	public function getResult()
    {
        return $this->result;
    }

	public function setAndroidApplicationName($applicationName)
    {
    	$this->androidApplicationName = $applicationName;
    }

	function verifyAndroidPurchase()
    {
        try {
            // Create new Google Client
            $client = new Google_Client();
            // Set Application Name to the name of the mobile app
            $client->setApplicationName($this->androidApplicationName);
         
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/android_credentials.json'));
            $client->useApplicationDefaultCredentials();
            $client->setScopes(config('store_validator.android_scopes'));
         
            // Create a new Android Publisher service class
            $service = new Google_Service_AndroidPublisher($client);

            $receipt = request('receipts');

            try {
               
                $product = $service->purchases_products->get($receipt['packageName'], $receipt['productId'], $receipt['purchaseToken']);

                if ($product) {
                	$this->verified = true;
                	$this->result = $product;
                }
            } catch (Google_Service_Exception $e) {
                return false;
            }

        } catch (Google_Auth_Exception $e) {
            // if the call to Google fails, throw an exception
            //throw new Exception('Error validating transaction', 500);
            return false;
        }

        return $this;
    }
}