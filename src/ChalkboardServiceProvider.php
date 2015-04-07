<?php namespace Behinddesign\Chalkboard;

use Illuminate\Support\ServiceProvider;

/**
 * This is the chalkboard service provider for laravel 5
 *
 */
class ChalkboardServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerChalkboard();
    }

    /**
     * Boots chalkboard and sets it up
     */
    protected function registerChalkboard()
    {
        $this->app->singleton('chalkboard', function () {
            return new Config();
        });

        $this->app->alias('chalkboard', 'Behinddesign\Chalkboard\Config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'chalkboard'
        ];
    }
}
