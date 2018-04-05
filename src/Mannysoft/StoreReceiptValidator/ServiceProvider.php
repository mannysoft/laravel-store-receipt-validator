<?php 

namespace Mannysoft\StoreReceiptValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Mannysoft\StoreReceiptValidator\StoreReceiptValidator;

class ServiceProvider extends BaseServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
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
