@props([
    'callback' => '',
    'errorCallback' => '',
    'theme' => 'auto',
    'language' => 'en-US',
    'size' => 'normal',
])

<div {{ $attributes->merge([
    'class' => 'cf-turnstile',
    'data-sitekey' => config('turnstile.turnstile_site_key'),
    'data-callback' => $callback,
    'data-error-callback' => $errorCallback,
    'data-theme' => $theme,
    'data-language' => $language,
    'data-size' => $size,
]) }}></div>

<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>