<?php

namespace RTMatt\MonthlyService;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use RTMatt\MonthlyService\Contracts\ServicePlanContract;
use RTMatt\MonthlyService\Contracts\ServiceReporter;

class ServicePlan extends Model implements ServicePlanContract, ServiceReporter
{

    protected $fillable = [
        'client_id',
        'hours_available_month',
        'hours_available_year',
        'standard_rate',
        'last_backup_datetime',
        'start_date'
    ];

    protected $dates = [ 'last_backup_datetime', 'start_date' ];

    protected $visible = [
        'id',
        'client_id',
        'hours_available_month',
        'hours_available_year',
        'standard_rate',
        'last_backup_datetime',
        'start_date'
    ];


    private static function generateServiceMonths($plan)
    {
        $plan_id = $plan->id;
        $month   = $plan->start_date->format('m');
        for ($i = 0; $i < 12; $i++) {
            $first_of_month = Carbon::createFromDate($plan->start_date->format('Y'), $month++, 1);
            $args           = [
                'start_date'      => $first_of_month,
                'service_plan_id' => $plan_id,
                'client_id'       => $plan->client_id
            ];
            if ($first_of_month < \Carbon\Carbon::now()) {
                $args['hours_used'] = 0;
            }
            ServiceMonth::create($args);
        }
    }


    private static function applyDefaultBenefits($plan)
    {
        $defaults = ServiceBenefit::getDefaultBenefits();
        foreach($defaults as $benefit){
            $benefit['service_plan_id']=$plan->id;
            ServiceBenefit::create($benefit);
        }

    }


    public function getLastBackup()
    {

        return $this->last_backup_datetime ?: 'No Backup Performed';
    }


    public static function create(array $attributes = [ ])
    {
        if ( ! array_key_exists('start_date', $attributes)) {
            throw new \RTMatt\MonthlyService\Exceptions\ServicePlanNoDateException();
        }
        $plan = parent::create($attributes);
        static::generateServiceMonths($plan);
        static::applyDefaultBenefits($plan);
        return $plan;

    }


    public function getServiceReportName()
    {
        return "Annual";
    }


    public function getAvailableHours()
    {

        return $this->hours_available_year;
    }


    public function getHoursUsed()
    {
        $used = 0;
        foreach ($this->service_months as $month) {
            $used += $month->hours_used;
        }

        return $used;
    }


    public function getMonthlyReports()
    {
        $service_month_reports = [ ];
        foreach ($this->service_months as $service_month) {
            $service_month_reports[] = $service_month->getUsageReport();
        }

        return $service_month_reports;
    }


    public function benefits()
    {
        return $this->hasMany('\RTMatt\MonthlyService\ServiceBenefit');
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function service_months()
    {
        return $this->hasMany('\RTMatt\MonthlyService\ServiceMonth');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Get associated Client instance
     */
    public function client()
    {
        return $this->belongsTo('\RTMatt\MonthlyService\Client');
    }


    public function getAnnualReport()
    {
        $report = new \RTMatt\MonthlyService\ClientAnnualUsageReport($this);

        return $report;
    }


    public function getStartDate()
    {
        return $this->start_date;
    }


    public function get_current_month()
    {
        $first_of_this_month = \Carbon\Carbon::parse('first day of ' . \Carbon\Carbon::now()->format('F Y'));

        return $this->service_months()->where('start_date', '=', $first_of_this_month)->get();
    }


    public function archive($new_plan_id)
    {
        $service_months         = $this->service_months();
        $service_months_content = $service_months->get()->toJson();
        $tmp                    = ArchivedPlan::create([
            'client_id'             => $this->client_id,
            'hours_available_month' => $this->hours_available_month,
            'hours_available_year'  => $this->hours_available_year,
            'standard_rate'         => $this->standard_rate,
            'last_backup_datetime'  => $this->last_backup_datetime,
            'start_date'            => $this->start_date,
            'service_history'       => $service_months_content

        ]);
        $this->benefits()->each(function ($item) use ($new_plan_id) {
            $item->update([ 'service_plan_id' => $new_plan_id ]);

        });
        $service_months->delete();
        $this->delete();

        return;
    }


    public function getClientID()
    {
        return $this->client_id;
    }


    public function getBenefits()
    {
        return $this->benefits;
    }
}