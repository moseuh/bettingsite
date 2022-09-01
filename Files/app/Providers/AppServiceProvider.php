<?php

namespace App\Providers;

use App\Event;
use View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\GeneralSettings;

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
        Schema::defaultStringLength(191);

        $data['basic'] =   GeneralSettings::first();
        $_ENV['admin'] =  $data['basic']->prefix;
        $data['tournaments'] = Event::where('status',1)->get();


        view::share($data);
    }
}
