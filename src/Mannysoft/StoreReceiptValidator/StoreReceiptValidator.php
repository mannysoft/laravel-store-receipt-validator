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
    
	protected $client;

	public $verified = false;
	public $result = null;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function validate($store)
    {
        if ($store == 'ios') {
        	return $this->verify();
        }

        return $store;
    }

    public function verifyPurchase(Request $request)
    {
        return $this->verify($request, $request->amount);
    }

    public function reverifyPurchase(Request $request)
    {
        return $this->verify($request);
    }

    public function verify()
    {
        $data['receipt-data'] = str_replace("\\", '', request('receipt-data'));

        if (config('store_validator.apple_verify_password')) {
        	$data['password'] = config('store_validator.apple_verify_password');
        }

        $options = [
           	'http' => [
            	'header'  => 'Content-type: application/json',
               	'method'  => 'POST',
               	'content' => json_encode($data)
           	],
       	];

        $context = stream_context_create($options);
        $result = file_get_contents(config('store_validator.apple_verify_receipt'), FALSE, $context);
        
        if ($result === FALSE) {
           return FALSe;
        }

        // Decode json object (TRUE variable decodes as an associative array)
        $result = json_decode($result, TRUE);

        $this->result = $result;
        
        // If we cant verify the purchase
        if ($result['status'] != 0) {
            return $this->couldNotVerify();
        }

        $result = collect($result['receipt']['in_app']);
        $sorted = $result->sortByDesc('purchase_date');
        $sorted = $sorted->values()->all();
        if ( ! isset($sorted[0])) {
            return $this->couldNotVerify();
        }

        $this->verified = true;

        return $this;
    }

    public function verifyPurchaseAndroid(Request $request)
    {
        return $this->verifyAndroid($request);
    }

    function verifyAndroid($request)
    {
        try {
            // Create new Google Client
            $client = new Google_Client();
            // Set Application Name to the name of the mobile app
            $client->setApplicationName('Fax');
         
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/android_credentials.json'));
            $client->useApplicationDefaultCredentials();
            $client->setScopes(['https://www.googleapis.com/auth/androidpublisher']);
         
            // Create a new Android Publisher service class
            $service = new Google_Service_AndroidPublisher($client);

            $receipts = $request->input('receipts');
            foreach ($receipts as $receipt) {
                try {
                    $product = $service->purchases_products->get($receipt['packageName'], $receipt['productId'], $receipt['purchaseToken']);
                    if ($product) {
                        $this->payments->paymentMethodId = 6;
                        $this->processBalance($request, $receipt['productId'], $product->developerPayload);
                    }
                } catch (Google_Service_Exception $e) {
                    return $this->couldNotVerify();
                }
            }

            return $this->accounts->balance();

        } catch (Google_Auth_Exception $e) {
            // if the call to Google fails, throw an exception
            //throw new Exception('Error validating transaction', 500);
            return $this->couldNotVerify();
        }


        // android-fax-to-receipt-validat@api-8244773268225794178-280058.iam.gserviceaccount.com
        // https://www.googleapis.com/androidpublisher/v2/applications/${packageName}/purchases/products/${productId}/tokens/${purchaseToken}?access_token=${access_token}
    }

    public function getData()
    {
    	return $this->result;
    }

}