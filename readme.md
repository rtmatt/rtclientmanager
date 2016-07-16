##Prerequisites:
 * Laravel 5.*
 * Auth Routes and Users Set Up
 * Correct Mail set up from the Mail::send facade
 
##Installation
### Via Composer

``` bash 
composer require rtmatt/rtclientmanager
```
###Add Service Providers

``` php 
\RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider::class,
'Barryvdh\Cors\ServiceProvider',
```

###Register middleware
in app/http/kernel
```  
'rtapi' => \RTMatt\MonthlyService\Middleware\RTAPIMiddleware::class
```

###Publish Migrations

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="migrations" 
```

### Run Migrations

``` bash 
php artisan migrate
```

###Publish public assets

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="public"
```


###Configure CORS


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


### Admin layout
Make you have the following in your admin layout:
* Bootstrap CSS (grid)
* jQuery


``` html 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
     <link href='{{asset('vendor/rtclientmanager/css/client-manager.css')}}' rel='stylesheet'>
```

### Configuration
You can publish configs with the following command

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="config" 
```



