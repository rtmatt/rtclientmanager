<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 6/10/16
 * Time: 1:24 PM
 */

namespace RTMatt\MonthlyService\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use RTMatt\MonthlyService\Client;
use RTMatt\MonthlyService\ServicePlan;

class ClientManagerAPIController extends Controller
{

    public function getClients()
    {
        $clients = Client::select('id', 'name')->get()->toArray();

        return json_encode($clients);
    }



    public function getClientServicePlan($client_id)
    {
        $client                   = Client::find($client_id);
        $plan                     = $client->service_plan()->select('id', 'start_date', 'hours_available_month',
            'hours_available_year', 'standard_rate')->first();
        $plan_array               = $plan->toArray();
        $plan_array['start_date'] = $plan->start_date->timestamp * 1000;

        return json_encode($plan_array);

    }


    public function getTemplates($slug)
    {
        $view_slug = 'rtdashboard::angular-templates.'.$slug;
        if(\View::exists($view_slug)){
            return view($view_slug);
        }
        abort(404);
    }

}