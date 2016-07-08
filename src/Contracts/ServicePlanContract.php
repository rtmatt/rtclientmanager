<?php
namespace RTMatt\MonthlyService\Contracts;

interface ServicePlanContract
{

    public function getLastBackup();


    public function getMonthlyReports();


    public function getDescription();


    public function getAnnualReport();


    public function getClientID();
}