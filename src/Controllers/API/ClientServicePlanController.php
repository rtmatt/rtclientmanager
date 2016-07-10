<?php

namespace RTMatt\MonthlyService\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RTMatt\MonthlyService\ServiceMonth;
use RTMatt\MonthlyService\ServicePlan;

/**
 * Class ClientServicePlanController
 * @package RTMatt\MonthlyService\Controllers
 */
class ClientServicePlanController extends Controller
{

    /**
     * Edit Service Plan With ID Param
     *
     * @param $id
     *
     * @return string
     */
    public function putIndex($service_plan, Request $request)
    {
        $month_string            = $request->input('active_month')['name'];
        $plan_keys               = $request->only('hours_available_year', 'standard_rate', 'hours_available_month');
        $plan_keys['start_date'] = \Carbon\Carbon::parse($month_string);
        $plan_keys['client_id']  = $service_plan->client_id;
        $plan_keys['last_backup_datetime'] = $service_plan->last_backup_datetime;
        $new_plan                = ServicePlan::create($plan_keys);
        $service_plan->archive($new_plan->id);

        return $new_plan;
    }


    public function putLog($service_plan, $service_month_id, Request $request)
    {
        $service_month        = ServiceMonth::findOrFail($service_month_id);
        $input['hours_used']  = $request->input('hours_logged');
        $input['description'] = $request->input('description');

        $service_month->update($input);

        return $service_month->toJson();
    }


    public function getHistory($service_plan)
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


    public function getBenefits($service_plan)
    {
        $benefits = $service_plan->benefits;

        return $benefits->toJson();
    }


    public function putBackup($service_plan, \Illuminate\Http\Request $request)
    {
        if (empty( $service_plan )) {
            return response("Service plan not found", 404);
        }

        $timestamp = $request->input('timestamp');
        if (empty( $timestamp )) {
            return response("Include a timestamp to log a backup.", 400);
        }
        $carbon = \Carbon\Carbon::createFromTimestamp(floor($timestamp / 1000));
        $service_plan->update([ 'last_backup_datetime' => $carbon ]);
        $format = $carbon->toDateTimeString();

        return response()->json([ 'backup_datetime' => $format ]);

    }


}