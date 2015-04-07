<?php namespace Behinddesign\Chalkboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Provide facade support for chalkboard
 */
class Chalkboard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chalkboard';
    }
}
