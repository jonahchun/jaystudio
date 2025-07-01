<?php

namespace App\Providers;

use App\Observers\InvoiceObserver;
use App\Observers\PhotographyCompleteObserver;
use App\Payments\Model\Invoice;
use App\Services\Model\Service;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Customer', \App\Customer\Model\Customer::class);
            $loader->alias('NewlywedPosition', \App\Customer\Model\Source\NewlywedPosition::class);
            $loader->alias('NewlywedType', \App\Customer\Model\Source\NewlywedType::class);
            $loader->alias('CustomerAdminGrid', \App\Customer\Block\Admin\Grid::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Invoice::observe(InvoiceObserver::class);
        Service::observe(PhotographyCompleteObserver::class);
    }
}
