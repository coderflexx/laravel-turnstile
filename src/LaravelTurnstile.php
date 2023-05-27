<?php

namespace Coderflex\LaravelTurnstile;

use Coderflex\LaravelTurnstile\Exceptions\SecretKeyNotFoundException;
use Coderflex\LaravelTurnstile\Exceptions\UnkownErrorOccuredException;
use Illuminate\Support\Facades\Http;

class LaravelTurnstile
{
    protected ?string $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function validate(string $cfResponse = null): array
    {
        $turnstileResponse = is_null($cfResponse)
            ? request()->get('cf-turnstile-response')
            : $cfResponse;

        if (! $secret = config('turnstile.turnstile_secret_key')) {
            throw new SecretKeyNotFoundException('Turnstile secret key is not defined.');
        }

        $response = Http::asJson()
            ->timeout(30)
            ->connectTimeout(10)
            ->throw(
                fn () => new UnkownErrorOccuredException(
                    'An unkown error occured, please refresh the page and try again.'
                )
            )
            ->post($this->getUrl(), [
                'secret' => $secret,
                'response' => $turnstileResponse,
            ]);

        return count($response->json())
            ? $response->json()
            : [
                'success' => false,
                'message' => 'Unknow error occured, please try again',
            ];
    }

    public function getUrl()
    {
        return $this->url;
    }
}
