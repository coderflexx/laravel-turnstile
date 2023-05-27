<?php

namespace Coderflex\LaravelTurnstile\Tests\Fixtures\Http\Controllers;

class TurnstileController extends Controller
{
    public function index()
    {
        return <<<'HTML'
            <form action="" method="post">
                <input type="text" name="name"/>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <x-turnstile-widget/>
            </form>
        HTML;
    }
}
