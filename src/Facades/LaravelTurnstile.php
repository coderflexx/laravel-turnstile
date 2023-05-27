<?php

namespace Coderflex\LaravelTurnstile\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Coderflex\LaravelTurnstile\LaravelTurnstile
 */
class LaravelTurnstile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Coderflex\LaravelTurnstile\LaravelTurnstile::class;
    }
}
