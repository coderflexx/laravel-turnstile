# Laravel Turnstile

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coderflex/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/coderflexx/laravel-turnstile)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/coderflexx/laravel-turnstile/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/coderflexx/laravel-turnstile/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/coderflexx/laravel-turnstile/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/coderflexx/laravel-turnstile/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/coderflex/laravel-turnstile.svg?style=flat-square)](https://packagist.org/packages/coderflex/laravel-turnstile)

__Laravel Turnstile__, is a package to help you implement [cloudflare turnstile](https://developers.cloudflare.com/turnstile/) easily, and with no time.

## Installation

You can install the package via composer:

```bash
composer require coderflex/laravel-turnstile
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="turnstile-config"
```


This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Turnstile Keys
    |--------------------------------------------------------------------------
    |
    | This value is the site, and the secret key of your application, after creating an application
    | with Cloudflare turnstile, copy the site key, and use it here, or in the .env
    | file.
    | Note that the secret key should not be publicly accessible.
    |
    | @see: https://developers.cloudflare.com/turnstile/get-started/#get-a-sitekey-and-secret-key
    |
    */
    'turnstile_site_key' => env('TURNSTILE_SITE_KEY', null),

    'turnstile_secret_key' => env('TURNSTILE_SECRET_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | Error Messages
    |--------------------------------------------------------------------------
    |
    | Here you can find the error messages for the application. You can modify
    | or translate the error message as you like.
    |
    | Note that you can translate the error message directly, without wrapping
    | them in translate helper.
    |
    */
    'error_messages' => [
        'turnstile_check_message' => 'The CAPTCHA thinks you are a robot! Please refresh and try again.',
    ],
];
```


Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="turnstile-views"
```

## Turnstile Keys
To be able to use __Cloudflare Turnstile__, you need to get the `SiteKey`, and the `SecretKey` from your [Cloudflare dashboard](https://developers.cloudflare.com/turnstile/get-started/#get-a-sitekey-and-secret-key)

After Generating the __keys__, use `TURNSTILE_SITE_KEY`, and `TURNSTILE_SECRET_KEY` in your `.env` file

```.env
TURNSTILE_SITE_KEY=2x00000000000000000000AB
TURNSTILE_SECRET_KEY=2x0000000000000000000000000000000AA
```

If you want to test the widget, you can use the [Dummy site keys and secret keys](https://developers.cloudflare.com/turnstile/reference/testing/) that Cloudflare provides.

## Usage

### Turnstile Widget Component

Once you require this package, you can use the turnstile widget in your form, like the following

```blade
<x-turnstile-widget 
    theme="dark"
    language="en-US"
    size="normal"
    callback="callbackFunction"
    errorCallback="errorCallbackFunction"
/>
```

As you can see, the widget has few options to use. You can know more about them in the [configuration section](https://developers.cloudflare.com/turnstile/get-started/client-side-rendering/#configurations)

### Turnstile Backend Validation

Once you used the widget component, in the frontend. You can validate __Cloudflare__ Response, by using the `validate` method.

Here's an example:

```php
use Coderflex\LaravelTurnstile\Facades\LaravelTurnstile;

public function store(Request $request)
{
    // maybe you want to validate your form first

    $response = LaravelTurnstile::validate();


    if (! $response['success']) { // will return boolean
        // do your logic
    }
}
```

You may, optionally, send the __Cloudflare__ response with the validation method. Something like the following:

```php
public function store(Request $request)
{
    ...
    $response = LaravelTurnstile::validate(
        $request->get('cf-turnstile-response'); // this will be created from the cloudflare widget.
    );
    ...
}
```

### Turnstile Custom Rule
If you want clean validation, you can use the `TurnstileCheck` custom rule, along with your form validation. Here's an example:

```php
use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;

public function store(Request $request)
{
    $request->validate([
        'cf-turnstile-response' => [new TurnstileCheck()]
    ]);
}
```

The custom rule, will use the same logic, as the __backend validation__, but instead will check for the response, and return a validation message, if the captcha fails.

You can change the content of the validation message, in `config/turnstile.php` file

```php
return [
    ...
    'error_messages' => [
        'turnstile_check_message' => 'The CAPTCHA thinks you are a robot! Please refresh and try again.',
    ],
];
```

__PS__: If you want to translate the message, just copy the message and translate it, because it uses the translator method behind the scene.


## Real Life Example
In your blade file

```blade
<form action="" method="post">
    @csrf
    <div>
        <input type="text" name="name" />
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-turnstile-widget theme="auto" language="fr"/>
        @error('cf-turnstile-response')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <button>Submit</button>
</form>
```

In your controller:

```php
use Coderflex\LaravelTurnstile\Rules\TurnstileCheck;
use Coderflex\LaravelTurnstile\Facades\LaravelTurnstile;

...

public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:250'],
        'cf-turnstile-response' => ['required', new TurnstileCheck()],
    ]);

    // or
    $response = LaravelTurnstile::validate();

    if (! $response['success']) {
        // do your thing.
    }

    // do your things.
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [ousid](https://github.com/ousid)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [the License File](LICENSE.md) for more information.
