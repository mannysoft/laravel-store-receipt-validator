<?php 

namespace Mannysoft\StoreReceiptValidator;

interface StoreInterface {

	public function validatePurchase($data);

	public function validateSubscription($data);

	public function getResult();

}