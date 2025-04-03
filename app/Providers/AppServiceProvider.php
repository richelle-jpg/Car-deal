<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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
        // Use Bootstrap 5 pagination styles
        Paginator::useBootstrapFive();

        // Share OrderCount with all views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $orderCount = Auth::user()->role == 'Administrator' 
                    ? Order::where('status', '=', 'incomplete')->count() 
                    : Order::where('user_id', '=', Auth::user()->id)->where('status', '=', 'incomplete')->count();
            } else {
                $orderCount = 0;
            }
            
            $view->with('OrderCount', $orderCount);
        });
    }
}
