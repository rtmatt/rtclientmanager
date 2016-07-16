##Installation

Prerequisites:
Laravel 5.*
Auth Set Up

Add Service Provider

``` php 
\RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider::class,
'Barryvdh\Cors\ServiceProvider',
```



###Publish Migrations

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="migrations" 
```

### Run Migrations

``` bash 
php artisan migrate
```

Publish public assets

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="public"
```


Configure CORS


```  
php artisan vendor:publish --provider="Barryvdh\Cors\ServiceProvider"
```


in config/cors.php

```  php
'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['POST'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
```

Make sure wrapper has authentication middleware defined 




Admin layout

``` html 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='/vendor/rtclientmanager/css/client-manager.css' rel='stylesheet'>
```

Configuration
Publish configs

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="config" 
```


Register middleware
in app/http/kernel

```  
'rtapi' => \RTMatt\MonthlyService\Middleware\RTAPIMiddleware::class
```



