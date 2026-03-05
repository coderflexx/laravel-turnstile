<?php

use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Illuminate\Support\Facades\Config;

it('returns success message', function () {
    setTurnstileRoutes(true);

    $response = $this->get('/turnstile');

    $this->assertStringContainsString(
        '<x-turnstile-widget/>', $response->getContent()
    );

    $response->assertOk();
});

it('fails validation for invalid input', function () {
    Config::set('turnstile', [
        'turnstile_site_key' => '2x00000000000000000000AB',
        'turnstile_secret_key' => '2x0000000000000000000000000000000AA',
    ]);

    $rule = new TurnstileCheck;

    $result = $rule->validate('cf-turnstile-response', 'invalid_input', fn () => '');

    expect($result)->toBeNull();
});
