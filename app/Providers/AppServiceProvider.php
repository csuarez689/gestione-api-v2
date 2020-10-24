<?php

namespace App\Providers;

use App\Models\OrdenMerito;
use App\Observers\OrdenMeritoObserver;
use Illuminate\Http\Resources\Json\JsonResource;
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
        JsonResource::withoutWrapping();
        OrdenMerito::observe(OrdenMeritoObserver::class);
    }
}
