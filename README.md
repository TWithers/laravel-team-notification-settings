# Laravel Team Notification Settings 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/twithers/laravel-team-notification-settings.svg?style=flat-square)](https://packagist.org/packages/twithers/laravel-team-notification-settings)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/twithers/laravel-team-notification-settings/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/twithers/laravel-team-notification-settings/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/twithers/laravel-team-notification-settings/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/twithers/laravel-team-notification-settings/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/twithers/laravel-team-notification-settings.svg?style=flat-square)](https://packagist.org/packages/twithers/laravel-team-notification-settings)

Allow every user belonging to a team/company/account customize individual notification settings. Send notifications to the team and have it dispatch the notification to all users subscribed to that specific notification. Customize specific notification requirements and thresholds (alert when over 90% for user A, 75% for user B, and do not notify user C).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-team-notification-settings.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-team-notification-settings)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require twithers/laravel-team-notification-settings
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-team-notification-settings-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-team-notification-settings-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-team-notification-settings-views"
```

## Usage

```php
$teamNotificationSettings = new TimWithers\TeamNotificationSettings();
echo $teamNotificationSettings->echoPhrase('Hello, TimWithers!');
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

- [Tim Withers](https://github.com/TWithers)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
