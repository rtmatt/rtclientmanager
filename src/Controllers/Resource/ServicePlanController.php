<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 7/15/16
 * Time: 11:48 AM
 */
namespace RTMatt\MonthlyService\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RTMatt\MonthlyService\ServicePlan;

class ServicePlanController extends Controller
{

    function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    public function update($service_plan, Request $request)
    {
        $month_string                       = $request->input('active_month')['name'];
        $plan_keys                          = $request->only('hours_available_year', 'standard_rate',
            'hours_available_month');
        $plan_keys['start_date']            = \Carbon\Carbon::parse($month_string);
        $plan_keys['client_id']             = $service_plan->client_id;
        $plan_keys['last_backup_datetime']  = $service_plan->last_backup_datetime;
        $plan_keys['skip_default_benefits'] = true;
        $new_plan                           = ServicePlan::create($plan_keys);
        $service_plan->archive($new_plan->id);

        return $new_plan;
    }


    public function putBackup(ServicePlan $service_plan, Request $request)
    {
        $timestamp = $request->input('timestamp');
        if (empty( $timestamp )) {
            return response("Include a timestamp to log a backup.", 400);
        }
        $carbon = \Carbon\Carbon::createFromTimestamp(floor($timestamp / 1000));
        $service_plan->update([ 'last_backup_datetime' => $carbon ]);
        $format = $carbon->toDateTimeString();

        return response()->json([ 'backup_datetime' => $format ]);
    }


    public function getBenefits(ServicePlan $service_plan)
    {
        $benefits = $service_plan->benefits;

        return $benefits->toJson();
    }


    public function getHistory(ServicePlan $service_plan)
    {
        $report = $service_plan->service_months;
        $result = [ ];
        foreach ($report as $service_month) {
            $result[] = [
                'id'           => $service_month->id,
                'name'         => $service_month->start_date->format('F Y'),
                'hours_logged' => $service_month->hours_used,
                'description'  => $service_month->description
            ];
        }

        return json_encode($result);
    }

}