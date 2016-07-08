<?php
namespace RTMatt\MonthlyService\Contracts;
use RTMatt\MonthlyService\Contracts\ServiceReporter;

interface ClientServicePeriod{

    public function __construct(ServiceReporter $reporter);

}