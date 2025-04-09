<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use MongoDB\Client;
use App\Models\ContectUsDetail;
use App\Models\Contact;
use App\Models\Setting;



class AppServiceProvider extends ServiceProvider
{
    protected $collection; // Define the collection property

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
    public function boot()
    {
        // Use Bootstrap pagination
        Paginator::useBootstrap();
    
        // Use View composer to always get the latest data
        View::composer('*', function ($view) {
            // Get the latest settings from MongoDB using Eloquent
            $websiteSetting = Setting::latest('_id')->first(); // Use '_id' to get latest if no created_at
    
            $view->with('appSetting', $websiteSetting);
    
            // Get latest contact data
            $contactData = ContectUsDetail::orderBy('created_at', 'desc')->get();
            $view->with('contactData', $contactData);
        });
    }
}