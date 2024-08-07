<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Services\Facades\Settings;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->bind(
            Settings::class,
            fn () => $this->app->make(SettingService::class)
        );

        $this->app->isProduction() || Model::shouldBeStrict();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
