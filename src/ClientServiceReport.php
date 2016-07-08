<?php

namespace RTMatt\MonthlyService;

class ClientServiceReport
{

    public $last_backup;

    public $monthly;

    public $description;

    public $annual;


    function __construct(\RTMatt\MonthlyService\Contracts\ServicePlanContract $plan)
    {
        $this->last_backup = $plan->getLastBackup();
        $this->monthly     = $plan->getMonthlyReports();
        $this->description = $plan->getDescription();
        $this->annual      = $plan->getAnnualReport();
    }
}