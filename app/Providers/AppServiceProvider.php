<?php

namespace App\Providers;

use App\Charts\NetRevenueByCustomerChart;
use App\Charts\NetRevenueByProductChart;
use App\Charts\RefundByCustomerChart;
use App\Charts\RefundByProductChart;
use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            NetRevenueByCustomerChart::class,
            NetRevenueByProductChart::class,
            RefundByCustomerChart::class,
            RefundByProductChart::class
        ]);
    }
}
