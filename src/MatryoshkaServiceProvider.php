<?php

namespace Achillesp\Matryoshka;

use Blade;
use Illuminate\Support\ServiceProvider;

class MatryoshkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('cache', function ($expression) {
            return "<?php if (! app('Achillesp\Matryoshka\BladeDirective')->setUp({$expression})) { ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php } echo app('Achillesp\Matryoshka\BladeDirective')->tearDown() ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BladeDirective::class, function () {
            return new BladeDirective(
                new RussianCaching(app('Illuminate\Contracts\Cache\Repository'))
            );
        });
    }
}
