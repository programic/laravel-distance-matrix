# Programic - Google Distance matrix

[![Latest Version on Packagist](https://img.shields.io/packagist/v/programic/laravel-distance-matrix.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-distance-matrix)
![](https://github.com/programic/laravel-distance-matrix/workflows/Run%20Tests/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/programic/laravel-distance-matrix.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-distance-matrix)

This package allows you to use get simple the duration and distance between two addresses by the Google Distance Matrix API

### Installation
This package requires PHP 7.2 and Laravel 5.8 or higher.

```
composer require programic/laravel-distance-matrix
```

### Basic Usage
```php
use \Programic\DistanceMatrix\DistanceMatrix

class DistanceController {

    public function index(DistanceMatrix $distanceMatrix)
    {
        $response = $distanceMatrix->from($from)->to($to)->calculate();
        
        $distance = $response->toArray();
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
