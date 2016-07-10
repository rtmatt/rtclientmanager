<?php

namespace RTMatt\MonthlyService\Exceptions;

class ServiceMonthNoDateException extends \Exception{
    protected $message = 'Service Month Creation Attempt With No Date.';
    protected $code = 500;
}
