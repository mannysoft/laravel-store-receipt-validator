<?php 

namespace Mannysoft\StoreReceiptValidator;

use Illuminate\Http\Request;
use Mannysoft\StoreReceiptValidator\StoreInterface;

class StoreReceiptValidator {
    
	public $verified = false;
	public $result = null;

    public function __construct($config = null)
    {
        
    }

    public function goValidate(StoreInterface $store, $data)
    {
    	return $store->validateSubscription($data);
    }

    // http://blog.goforyt.com/validating-ios-app-purchases-laravel/
    // to do: support for amazon and unity purchase
    // to do: validation of receipt via laravel form validation
    public function validate($store, $requestData = null)
    {
    	$storeValidator = new \Mannysoft\StoreReceiptValidator\Android();
    	if ($store == 'ios') {
    		$storeValidator = new \Mannysoft\StoreReceiptValidator\Apple();
    	}
		return $this->goValidate($storeValidator, $requestData);
    }

    public function couldNotVerify()
    {
        return response()->json([
            'status' => 'failed', 
            'message' => 'We could not verify the purchase!',
            ],
            403
        );
    }

    public function getData()
    {
    	return $this->result;
    }

    public function statusUpdateNotification($store = 'ios', $data = null)
    {
    	// --- apple ---
    	// INITIAL_BUY
        // CANCEL
        // RENEWAL
        // INTERACTIVE_RENEWAL
        // DID_CHANGE_RENEWAL_PREFERENCE

    	// --- android ---
    	// those are intergers
    	// SUBSCRIPTION_PURCHASED - 4
    	// SUBSCRIPTION_RENEWED - 2
    	// SUBSCRIPTION_RECOVERED - 1
    	// SUBSCRIPTION_CANCELED - 3
    	// SUBSCRIPTION_ON_HOLD - 5
    	// SUBSCRIPTION_IN_GRACE_PERIOD - 6
    	// SUBSCRIPTION_RESTARTED - 7
    	//return $data;
        //$testing = true;
        if ($store == 'ios') {
        	return $this->processKind(request('notification_type'), $data);
        }

        return $this->processKind(request('notification_type'), $data);
    }

    public function processKind($kind, $data)
    {
        if ($kind == 'INITIAL_BUY') {
            return $this->initial($data);
        }
        if ($kind == 'CANCEL') {
            return $this->cancel($data);
        }
        if ($kind == 'RENEWAL') {
            return $this->renewal($data);
        }
        if ($kind == 'INTERACTIVE_RENEWAL') {
            return $this->interactiveRenewal($data);
        }
        if ($kind == 'DID_CHANGE_RENEWAL_PREFERENCE') {
            return $this->changeRenewalPref($data);
        }
    }

    public function initial($data)
    {

    }

    public function cancel($data)
    {

    }

    public function renewal($data)
    {
    	return $data;
    }

    public function interactiveRenewal($data)
    {

    }

    public function changeRenewalPref($data)
    {

    }

}