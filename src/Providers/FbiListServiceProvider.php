<?php

namespace Jota\FbiList\Providers;

use Illuminate\Support\ServiceProvider;
use Jota\FbiList\Classes\FbiList;

class FbiListServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind('FbiList', function () {
            return new FbiList();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $this->publishes([
            __DIR__ . '/../../config/fbilist.php' => config_path('fbilist.php'),
        ]);
    }
}
