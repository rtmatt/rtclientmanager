<?php

namespace RTMatt\MonthlyService\Exceptions;

class ServiceMonthIncompatableStartDateException extends \Exception{
    protected $message = 'Service Month Start Date is Not an Instance of Carbon';
    protected $code = 500;
}
