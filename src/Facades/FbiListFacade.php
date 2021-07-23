<?php

namespace Jota\EUTerroristList\Facades;

use Illuminate\Support\Facades\Facade;

class EUTerroristListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'EUTerroristList';
    }
}
