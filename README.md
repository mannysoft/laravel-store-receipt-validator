# Validator
Laravel receipt validator for Apple iTunes, Google Play
To publish the config settings in Laravel 5 use:

#Installation

Require this package with composer.

```shell
composer require mannysoft/laravel-store-receipt-validator:dev-master
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
Mannysoft\StoreReceiptValidator\ServiceProvider::class,
```

```php
php artisan vendor:publish --provider="Mannysoft\StoreReceiptValidator\ServiceProvider"
```