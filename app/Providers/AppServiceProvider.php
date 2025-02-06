<?php

namespace App\Providers;

use App\Services\BranchService;
use App\Services\CategoryService;
use App\Services\GlobalSettingService;
use App\Services\ProductRelationPriceService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('consumer', function () {
            return session('api_token') && session('user') && session('user')->role === 'CONSUMER';
        });
        Blade::if('guest', function () {
            return !session('api_token') || !session('user');
        });

        Cache::rememberForever('branches', function () {
            return BranchService::get();
        });

        Cache::rememberForever('globalSettings', function () {
            return GlobalSettingService::get();
        });

        Cache::rememberForever('categories', function () {
            return CategoryService::get();
        });
        Cache::rememberForever('products', function () {
            return ProductService::get([
                'show_hierarchy' => 'true',
            ]);
        });
        /*Cache::rememberForever('branch_categories', function () {
            return BranchService::getCategories();
        });
        Cache::rememberForever('branch_products', function () {
            return BranchService::getProducts();
        });*/
    }
}
