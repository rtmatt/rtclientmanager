##Installation

###Publish Migrations

``` bash 
php artisan vendor:publish --provider="RTMatt\MonthlyService\Providers\MonthlyServiceServiceProvider" --tag="migrations" 
```

### Run Migrations

``` bash 
php artisan migrate
```



