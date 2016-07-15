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



