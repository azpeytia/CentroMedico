<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\InventoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ShiftRepository;
use App\Services\InventoryService;
use App\Services\ProductService;
use App\Services\ShiftService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InventoryRepository::class, function ($app) {
            return new InventoryRepository();
        });

        $this->app->bind(InventoryService::class, function ($app) {
            return new InventoryService($app->make(InventoryRepository::class));
        });

        $this->app->bind(ShiftRepository::class, function ($app) {
            return new ShiftRepository();
        });

        $this->app->bind(ShiftService::class, function ($app) {
            return new ShiftService($app->make(ShiftRepository::class));
        });

        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository();
        });

        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
