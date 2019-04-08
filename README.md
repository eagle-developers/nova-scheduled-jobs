# Nova Scheduled Tasks

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eagle-developers/nova-scheduled-tasks.svg?style=flat-square)](https://packagist.org/packages/eagle-developers/nova-scheduled-tasks)
[![Total Downloads](https://img.shields.io/packagist/dt/eagle-developers/nova-scheduled-tasks.svg?style=flat-square)](https://packagist.org/packages/eagle-developers/nova-scheduled-tasks)

## Includes both a tool and card to display your scheduled commands and tasks

![Nova Scheduled Tasks Tool Screenshot](https://user-images.githubusercontent.com/4362516/55746628-c64d5480-59ff-11e9-99a7-5d4de353d1d8.png)

![Nova Scheduled Tasks Card Screenshot](https://user-images.githubusercontent.com/4362516/55746634-cbaa9f00-59ff-11e9-968e-c8c66a5fe2d4.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require eagle-developers/nova-scheduled-tasks
```

To setup the tool, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \EagleDevelopers\NovaScheduledTasks\NovaScheduledTasksTool,
    ];
}
```

To setup the card, you must register the card with Nova. This is typically done in the `cards` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function cards()
{
    return [
        // ...
        new \EagleDevelopers\NovaScheduledTasks\NovaScheduledTasksCard,
    ];
}
```

### Testing

``` bash
phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Eagle Developers](https://github.com/eagle-developers)
- [Larry Laski](https://github.com/llaski)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
