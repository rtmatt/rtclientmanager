<?php

namespace RTMatt\MonthlyService\Contracts;

/**
 * Interface ServiceReporter
 * @package RTMatt\MonthlyService\Contracts
 *          Database entity that generates proper information for a service report
 */
interface ServiceReporter{

    public function getServiceReportName();

    public function getAvailableHours();

    public function getHoursUsed();


    public function getStartDate();

}