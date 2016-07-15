##Installation

###Publish Migrations

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="migrations" 
```

### Run Migrations

``` bash 
php artisan migrate
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




