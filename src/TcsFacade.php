<?php 
namespace Tiup\Tcs;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tiup\LaravelTiupSdk\LaravelTiupSdk
 */
class TcsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * Don't use this. Just... don't.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Tiup\Tcs';
    }
}
