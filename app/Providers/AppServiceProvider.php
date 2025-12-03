<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\Keranjang;

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
        View::composer('*', function ($view) {
            $totalKeranjang = 0;
            
            if (Session::has('kode_customer')) {
                $kode_cs = Session::get('kode_customer');
                
                $totalKeranjang = Keranjang::where('kode_customer', $kode_cs)->count();
            }

            $view->with('totalKeranjang', $totalKeranjang);
        });
    if($this->app->environment('production') || str_contains(request()->url(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }
    }

}