<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

[Official skeleton: https://github.com/laravel/laravel](https://github.com/laravel/laravel)

## Bake Module

Run:

```
php artisan bake:module [name]
```

Run name on plural and lower case, example:

```
php artisan bake:module pages
```

Register provider in config/app.php, see command result. Example of command result:

```
Add this provider to config/app.php:
Modules\Pages\Providers\PageServiceProvider::class,
```

## CrudController and ApiController

Two simple traits to crud on Laravel.

See files in `app/Http/Controllers/ApiControllerTrait.php` and  `app/Http/Controllers/CrudControllerTrait.php` and example in your `Controllers` directory on module.

## UploadObserverTrait

Example:

```
<?php

namespace Modules\MyModule\Observers;

use Modules\MyModule\Models\Profile;

class ProfileObserver
{
    use UploadObserverTrait;

    protected $field = 'photo';
    protected $path = 'profile_photos/';

    public function creating(Profile $model)
    {
        $this->sendFile($model);
    }

    public function deleting(Profile $model)
    {
        $this->removeFile($model);
    }

    public function updating(Profile $model)
    {
        $this->updateFile($model);
    }
}

```

## TODO

 - AdminLTE
 - Auth with Email and Socialite
 - CORS package (barryvdh/laravel-cors)
 - OAuth 2 with Passport and Social Networks
 - Enable S3 upload default
