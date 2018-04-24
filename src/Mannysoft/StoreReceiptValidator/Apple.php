<?php 

namespace Mannysoft\StoreReceiptValidator;

use Mannysoft\StoreReceiptValidator\StoreInterface;

class Apple implements StoreInterface {
	
	public $verified = false;
	public $result = null;

	public function validatePurchase($requestData)
	{
		// $data['receipt-data'] = str_replace("\\", '', $requestData['receipt-data']);

  //       if (config('store_validator.apple_verify_password')) {
  //       	$data['password'] = config('store_validator.apple_verify_password');
  //       }

  //       $options = [
  //          	'http' => [
  //           	'header'  => 'Content-type: application/json',
  //              	'method'  => 'POST',
  //              	'content' => json_encode($data)
  //          	],
  //      	];

  //       $context = stream_context_create($options);
  //       $result = file_get_contents(config('store_validator.apple_verify_receipt'), FALSE, $context);
        
  //       if ($result === FALSE) {
  //          return false;
  //       }

  //       // Decode json object (TRUE variable decodes as an associative array)
  //       $result = json_decode($result, TRUE);

  //       $this->result = $result;
        
  //       // If we cant verify the purchase
  //       if ($result['status'] != 0) {
  //           return false;
  //       }

  //       $result = collect($result['receipt']['in_app']);
  //       $sorted = $result->sortByDesc('purchase_date');
  //       $sorted = $sorted->values()->all();
  //       if ( ! isset($sorted[0])) {
  //           return false;
  //       }

  //       $this->verified = true;

  //       return $this;
	}

	public function validateSubscription($requestData)
	{
		$data['receipt-data'] = str_replace("\\", '', $requestData['receipt-data']);
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
           return false;
        }

        // Decode json object (TRUE variable decodes as an associative array)
        $result = json_decode($result, TRUE);

        $this->result = $result;
        
        // If we cant verify the purchase
        if ($result['status'] != 0) {
            return false;
        }

        $result = collect($result['receipt']['in_app']);
        $sorted = $result->sortByDesc('purchase_date');
        $sorted = $sorted->values()->all();
        if ( ! isset($sorted[0])) {
            return false;
        }

        $this->verified = true;

        return $this;
	}

	public function getResult()
	{
		return 'data';
	}
}