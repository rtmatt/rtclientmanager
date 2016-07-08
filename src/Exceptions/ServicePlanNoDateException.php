<?php

namespace RTMatt\MonthlyService\Exceptions;

class ServicePlanNoDateException extends \Exception{
    protected $message = 'Service Plan Creation Attempt With No Date.';
    protected $code = 500;
}