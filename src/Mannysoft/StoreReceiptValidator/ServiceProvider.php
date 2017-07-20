<?php 

namespace Mannysoft\StoreReceiptValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/receiptvalidator.php' => config_path('receiptvalidator.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/receiptvalidator.php', 'vatlayer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('vat-layer', function() {
            //$apiKey = config('vatlayer.api_key');
            //return new VatLayer();
        //});
    }

}
