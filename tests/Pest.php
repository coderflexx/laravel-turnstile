<?php

use Coderflex\LaravelTurnstile\Tests\Fixtures\Http\Controllers\TurnstileController;
use Coderflex\LaravelTurnstile\Tests\TestCase;
use Illuminate\Support\Facades\Route;

uses(TestCase::class)->in(__DIR__);

function setTurnstileRoutes(bool $get = false)
{
    if ($get) {
        Route::get('/turnstile', [TurnstileController::class, 'index']);
    }
}
