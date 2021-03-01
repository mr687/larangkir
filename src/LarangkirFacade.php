<?php

namespace Mr687\Larangkir;

use Illuminate\Support\Facades\Facade;

class LarangkirFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larangkir';
    }
}
