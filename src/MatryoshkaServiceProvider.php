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
        if ($this->app->isLocal()) {
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
