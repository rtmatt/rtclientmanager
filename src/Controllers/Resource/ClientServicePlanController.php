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
use RTMatt\MonthlyService\Client;

class ClientServicePlanController extends Controller
{

    function __construct()
    {
        $this->middleware(['web','auth']);
    }


    public function index(Client $clients)
    {
        $plan                     = $clients->service_plan()->select('id', 'start_date', 'hours_available_month',
            'hours_available_year', 'standard_rate')->first();
        $plan_array               = $plan->toArray();
        $plan_array['start_date'] = $plan->start_date->timestamp * 1000;

        return json_encode($plan_array);
    }
}