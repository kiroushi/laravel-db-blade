# Laravel DB Blade

[![Build Status](https://travis-ci.org/kiroushi/laravel-db-blade.svg?branch=master)](https://travis-ci.org/kiroushi/laravel-db-blade)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kiroushi/laravel-db-blade/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kiroushi/laravel-db-blade/?branch=master)

## Render Blade templates from Eloquent Model Fields

This package allows you to render Blade templates from a database model instead of files. It is based on [Flynsarmy](https://github.com/Flynsarmy/)'s [**laravel-db-blade-compiler**](https://github.com/Flynsarmy/laravel-db-blade-compiler).


## Installation

You can install the package via composer:

``` bash
composer require kiroushi/laravel-db-blade
```

Publish the assets using artisan:

```bash
php artisan vendor:publish
```

And then set up your DbView model in the `config/db-blade.php` configuration file. A default model (**Kiroushi\DbBlade\Models\DbView**) is included in the package:

```php
return [

    'model_name' => 'Kiroushi\DbBlade\Models\DbView',
    'table_name' => 'db_views',

    /**
     * The default name field used to look up for the model.
     * e.g. DbView::make($viewName) or dbview($viewName)
     */
    'name_field' => 'name',

    /**
     * The default model field to be compiled when not explicitly specified
     * with DbView::field($fieldName) or DbView::model($modelName, $fieldName)
     */
    'content_field' => 'content',

    /**
     * This property will be added to models being compiled with DbView
     * to keep track of which field in the model is being compiled
     */
    'model_property' => '__db_blade_compiler_content_field',

    'cache' => false,
    'cache_path' => 'app/db-blade/cache/views'

];
```

After the configuration and ensuring that the migration has been published, you can create the database views table by running the migrations:

```bash
php artisan migrate
```

## Usage

This package offers a `DbView` facade with the exact same syntax and functionality than `View`:

```php
return DbView::make('home')->with(['foo' => 'bar']);
```

You can also use the `dbview()` helper matching Laravel's base `view()` helper functionality. If no arguments are supplied, the factory is returned:

```php
return dbview()->make('home')->with(['foo' => 'bar']);
```

If a string is supplied, a view with that name will be looked up for and rendered:

```php
return dbview('home')->with(['foo' => 'bar']);
```

### Overriding settings at runtime

You can override individual settings for the model, name field and content field by using associated methods:

```php
return DbView::make('home')->model('App\Template');

return DbView::make('home')->field('template_name');

// You can also pass the model and name field as a shorthand:
return DbView::make('home')->model('App\Template', 'template_name');

// Override content field
return DbView::make('home')->contentField('template_content');

// ... or a combination of these
return DbView::make('home')->model('App\Template', 'template_name')->contentField('template_content');
```

### Cache

By default, cache is disabled in config file. If you enable the setting, a compiled version of the views will be stored at the desired path. If the model is updated, the *updated_at* field will be checked against the file modification date and the view will be re-rendered and cached.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## To do list

- Expose view finder callback
- Separate standard view composers from dbview composers.
- Unit tests

## License

**laravel-db-blade** is open-sourced software licensed under the MIT License (MIT). Please see [License File](LICENSE.md) for more information.
