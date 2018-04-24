<?php 

namespace Mannysoft\StoreReceiptValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Mannysoft\StoreReceiptValidator\StoreReceiptValidator;
use Illuminate\Support\Facades\Validator;

class ServiceProvider extends BaseServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('valid_receipt_ios', function ($attribute, $value, $parameters, $validator) {
            // Validate the receipt-data
            return store_validate_subscription('ios', request()->all());
        });
        Validator::extend('valid_receipt_android', function ($attribute, $value, $parameters, $validator) {
            // Validate the receipt-data
            return store_validate_subscription('ios', request()->all());
        });

        $this->publishes([
            __DIR__ . '/../../config/store_validator.php' => config_path('store_validator.php'),
        ]);
        
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/store_validator.php', 'store_validator'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('store_receipt_validator', function() {
            return new StoreReceiptValidator(config('store_validator'));
        });
    }

}
