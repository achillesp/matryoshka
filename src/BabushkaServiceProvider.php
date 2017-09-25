<?php

namespace Achillesp\Babushka;

use Blade;
use Illuminate\Support\ServiceProvider;

class BabushkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('cache', function ($expression) {
            return "<?php if (! Achillesp\Babushka\RussianCaching::setUp({$expression})) { ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php } echo Achillesp\Babushka\RussianCaching::tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
