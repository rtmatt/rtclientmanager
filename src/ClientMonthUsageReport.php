<?php

namespace RTMatt\MonthlyService;

use RTMatt\MonthlyService\Contracts\ServiceReporter;

/**
 * Class MonthUsage
 * @package RTMatt\MonthlyService
 *          Generates report for service usage for a month
 */
class ClientMonthUsageReport implements \RTMatt\MonthlyService\Contracts\ClientServicePeriod
{

    private $reporter;


    function __construct(ServiceReporter $reporter)
    {
        $this->reporter         = $reporter;
        $this->name             = $reporter->getServiceReportName();
        $this->hours_available  = $reporter->getAvailableHours();
        $this->hours_used       = $reporter->getHoursUsed();
        $this->percentage_used  = $this->getPercentageHoursUsed();
        $this->is_current_month = $this->checkCurrentMonth();
    }


    public function getReporter()
    {
        return $this->reporter;
    }


    private function getPercentageHoursUsed()
    {
        if ($this->hours_available <= 0) {
            return 1;
        }

        return $this->hours_used / $this->hours_available * 100;
    }


    private function checkCurrentMonth()
    {
        $now            = \Carbon\Carbon::now()->format('F Y');
        $reporter_month = $this->reporter->getStartDate()->format('F Y');

        return $now == $reporter_month;
    }
}