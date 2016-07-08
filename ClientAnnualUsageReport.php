<?php

namespace RTMatt\MonthlyService;

use RTMatt\MonthlyService\Contracts\ServiceReporter;

class ClientAnnualUsageReport implements \RTMatt\MonthlyService\Contracts\ClientServicePeriod
{

    public function __construct(ServiceReporter $reporter)
    {
        $this->reporter        = $reporter;
        $this->name            = $reporter->getServiceReportName();
        $this->hours_available = $reporter->getAvailableHours();
        $this->hours_used      = $reporter->getHoursUsed();
        $this->percentage_used = $this->getPercentageHoursUsed();
    }


    private function getPercentageHoursUsed()
    {
        if ($this->hours_available <= 0) {
            return 1;
        }

        return $this->hours_used / $this->hours_available * 100;
    }
}