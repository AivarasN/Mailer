<?php namespace Services\Mailtrap\Facades;

use Illuminate\Support\Facades\Facade;

class Mailtrap extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailtrap';
    }

}