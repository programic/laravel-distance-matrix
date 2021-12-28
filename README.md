# Programic - Repositories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/programic/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-repository)
![](https://github.com/programic/laravel-repository/workflows/Run%20Tests/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/programic/laravel-repository.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-repository)

This package allows you to use Repositories and keeps the controllers clean

### Installation
This package requires PHP 7.2 and Laravel 5.8 or higher.

```
composer require programic/laravel-repository
```

### Basic Usage
```bash
# Create Repository
php artisan make:repository UserRepository
```

```php
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController {

    public function index(Request $request, UserRepository $userRepository)
    {
        $userCollection = $userRepository->search($request)->get();
    }
    
} 
```


### Testing
```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email [info@programic.com](mailto:info@programic.com) instead of using the issue tracker.

## Credits

- [Rick Bongers](https://github.com/rbongers)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
