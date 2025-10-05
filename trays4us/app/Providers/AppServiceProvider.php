<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\SiteManagements;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
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
    public function boot()
    {

        $siteManagement  = SiteManagements::getSiteManagment();
        if($siteManagement)
            View::share('site_management', $siteManagement);

        view()->composer('*', function ($view)
        {
            view()->composer('*', function($view)
            {
                if(Session::has('is_customer') && !empty(Session::get('is_customer'))){

                    $is_customer = Session::get('is_customer');
                    $totalQuantity = Cart::where('customer_id',  $is_customer->id)->sum('quantity');
                    $view->with('total_item_quantity', $totalQuantity );
                }
            });
        });
    }
}
