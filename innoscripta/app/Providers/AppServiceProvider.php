<?php

namespace App\Providers;

use App\Constants\SettingConstants;
use App\Managers\SettingManager;
use Illuminate\Support\ServiceProvider;
use Kavenegar\KavenegarApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(KavenegarApi::class, function ($app) {
            /** @var SettingManager $settingManager */
            $settingManager = resolve(SettingManager::class);
            return new KavenegarApi(
                $settingManager->get(SettingConstants::KAVEHNEGAR_API_KEY)
            );
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
