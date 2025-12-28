# License System Plugin

A professional, secure, and easy-to-integrate license verification system for Laravel applications.

## Features

- **Remote Verification**: Verifies license keys against your central Burhan Labs Pvt. Ltd.
- **Domain Locking**: Prevents unauthorized usage on multiple domains.
- **Secure Communication**: Uses hidden, encoded endpoints to protect your licensing server.
- **Plug & Play**: Easy installation via Composer.
- **Professional UI**: Built-in, responsive license verification page.

## Installation

### 1. Install via Composer

#### Option A: From GitHub (Private/Public Repository)

Add the repository to your project's `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:itsburhan126/license-system.git"
    }
],
```

Then require the package:

```bash
composer require codelab/license-system
```

#### Option B: Local Development

If you are developing locally, add this to `composer.json`:

```json
"repositories": [
    {
        "type": "path",
        "url": "../path/to/plugin"
    }
],
```

### 2. Publish Configuration (Optional)

The core configuration is secure and automated. You can publish the config file if you need to customize default behaviors (though usually not required):

```bash
php artisan vendor:publish --tag=license-config
```

### 3. Environment Setup

Add your license key to the `.env` file of your Laravel application:

```env
LICENSE_KEY=YOUR-LICENSE-KEY-HERE
```

*Note: The Server URL is pre-configured within the plugin for security.*

### 4. Register Middleware

Protect your application by adding the middleware to `bootstrap/app.php` (Laravel 11+) or `app/Http/Kernel.php` (Laravel 10 and below).

**Laravel 11+ (`bootstrap/app.php`):**

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \CodeLab\LicenseSystem\Http\Middleware\CheckLicense::class,
    ]);
})
```

**Laravel 10 (`app/Http/Kernel.php`):**

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \CodeLab\LicenseSystem\Http\Middleware\CheckLicense::class,
    ],
];
```

## Usage

Once installed, the middleware will automatically intercept requests.
- **Valid License**: The request proceeds normally.
- **Invalid/Missing License**: The user is redirected to a professional "License Verification" page where they can enter their key.
- **Connection Failure**: If the licensing server is unreachable, access is temporarily blocked for security.

## Security

This plugin uses several security measures:
- **Obfuscated Endpoints**: The verification server URL is Base64 encoded and hidden within the compiled code.
- **Domain Validation**: Checks if the license is authorized for the current host domain.
- **Middleware Protection**: Blocks access at the application level before any controllers are hit.

## License

MIT License. See [LICENSE](LICENSE) for details.
