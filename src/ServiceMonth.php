<?php
namespace RTMatt\MonthlyService;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceMonth extends Model implements \RTMatt\MonthlyService\Contracts\ServiceReporter
{

    protected $fillable = [ 'client_id', 'start_date', 'hours_used', 'service_plan_id' ,'description'];

    protected $dates = [ 'start_date' ];


    public function getServiceReportName()
    {
        return $this->pretty_name;
    }


    public function getPrettyNameAttribute()
    {
        if ( ! $this->start_date instanceof Carbon) {
            throw new \RTMatt\MonthlyService\Exceptions\ServiceMonthIncompatableStartDateException();
        }

        return $this->start_date->format('M');

    }


    public static function create(array $attributes = [ ])
    {
        if ( ! array_key_exists('start_date', $attributes)) {
            throw new \RTMatt\MonthlyService\Exceptions\ServiceMonthNoDateException();
        }

        return parent::create($attributes);

    }


    public function getAvailableHours()
    {

        if ( ! empty( $this->service_plan->hours_available_month )) {
            return $this->service_plan->hours_available_month;
        }

        return 0;
    }


    public function service_plan()
    {
        return $this->belongsTo('\RTMatt\MonthlyService\ServicePlan');
    }


    public function getHoursUsed()
    {
        if (is_null($this->hours_used)) {
            return "-";
        }

        return $this->hours_used;
    }


    public function getUsageReport()
    {
        return new \RTMatt\MonthlyService\ClientMonthUsageReport($this);
    }


    public function getStartDate()
    {
        return $this->start_date;
    }
}