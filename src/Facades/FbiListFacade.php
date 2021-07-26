<?php

namespace Jota\FbiList\Facades;

use Illuminate\Support\Facades\Facade;

class FBIListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FBIList';
    }
}
