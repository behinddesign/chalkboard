<?php namespace Behinddesign\Chalkboard;

use Illuminate\Support\Facades\Facade;

/**
 * Provide facade support for chalkboard
 */
class DigitalOcean extends Facade
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
