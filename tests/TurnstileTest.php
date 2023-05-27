<?php

it('returns success message', function () {
    setTurnstileRoutes(true);

    $response = $this->get('/turnstile');

    $this->assertStringContainsString(
        '<x-turnstile-widget/>', $response->getContent()
    );

    $response->assertOk();
});
