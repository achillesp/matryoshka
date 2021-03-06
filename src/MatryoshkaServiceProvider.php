<?php

namespace Achillesp\Matryoshka;

use Blade;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class MatryoshkaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @param Kernel $kernel
     */
    public function boot(Kernel $kernel)
    {
        $this->publishes([
            __DIR__.'/../config/matryoshka.php' => config_path('matryoshka.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/matryoshka.php', 'matryoshka');

        if ($this->app->isLocal() && config('matryoshka.flush_cache_on_local')) {
            $kernel->pushMiddleware('Achillesp\Matryoshka\FlushViews');
        }

        Blade::directive('cache', function ($expression) {
            return "<?php if (! app('Achillesp\Matryoshka\BladeDirective')->setUp({$expression})) : ?>";
        });

        Blade::directive('endcache', function () {
            return "<?php endif; echo app('Achillesp\Matryoshka\BladeDirective')->tearDown(); ?>";
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(BladeDirective::class);
    }
}
