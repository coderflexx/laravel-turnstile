<?php

namespace Coderflex\LaravelTurnstile\Components;

use Illuminate\View\Component;

class TurnstileWidget extends Component
{
    public function render()
    {
        return view('turnstile::components.turnstile-widget');
    }
}
