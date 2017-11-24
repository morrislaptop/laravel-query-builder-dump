# Query Builder Dump

![Screenshot of code](https://pbs.twimg.com/media/DPZ96-zXUAEbs3L.jpg:large)

``` php
array:3 [
  "bindings" => array:6 [
    "select" => []
    "join" => []
    "where" => array:1 [
      0 => Illuminate\Support\Carbon {#736
        +"date": "2017-11-24 15:10:26.000000"
        +"timezone_type": 3
        +"timezone": "UTC"
      }
    ]
    "having" => []
    "order" => []
    "union" => []
  ]
  "sql" => "select * from `prizes` where `comment_id` is null and `release_at` < ? order by `release_at` asc"
  "raw" => "select * from `prizes` where `comment_id` is null and `release_at` < '2017-11-24 15:10:26' order by `release_at` asc"
]
```

[![Latest Version on Packagist](https://img.shields.io/packagist/v/morrislaptop/laravel-query-builder-dump.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-query-builder-dump)
[![Build Status](https://img.shields.io/travis/morrislaptop/laravel-query-builder-dump/master.svg?style=flat-square)](https://travis-ci.org/morrislaptop/laravel-query-builder-dump)
[![Quality Score](https://img.shields.io/scrutinizer/g/morrislaptop/laravel-query-builder-dump.svg?style=flat-square)](https://scrutinizer-ci.com/g/morrislaptop/laravel-query-builder-dump)
[![Total Downloads](https://img.shields.io/packagist/dt/morrislaptop/laravel-query-builder-dump.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-query-builder-dump)

This repository contains a dump method for the query builder, allowing you to dump your query inline. Similar to `$collection->dump();`

## Installation

You can pull in the package via composer:

``` bash
composer require morrislaptop/laravel-query-builder-dump --dev
```

The package will automatically register itself.

## Usage

Simply call dump anywhere when constructing your query.

```php
$users = DB::table('users')
           ->select('name', 'email as user_email')
           ->join('contacts', 'users.id', '=', 'contacts.user_id')
           ->union($first)
           ->dump()
           ->where('something', 'true')
           ->orWhere('name', 'John')
           ->orderBy('name', 'desc')
           ->groupBy('account_id')
           ->dump()
           ->offset(10)
           ->limit(5)
           ->having('account_id', '>', 100)
           ->get();
```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email cr@igmorr.is instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
