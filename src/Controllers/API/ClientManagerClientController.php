<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 6/15/16
 * Time: 1:57 PM
 */

namespace RTMatt\MonthlyService\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RTMatt\MonthlyService\Client;
use RTMatt\MonthlyService\ServicePlan;

class ClientManagerClientController extends Controller
{

    public function index()
    {
        $clients = Client::select('id', 'name')->get()->toArray();

        return json_encode($clients);
    }


    public function store(Request $request)
    {


        $client_data = $request->only('name', 'primary_contact_name', 'primary_contact_email', 'primary_contact_phone');
        $plan_data   = $request->only('hours_available_month', 'hours_available_year', 'standard_rate','start_date');

        $plan_data['start_date'] = \Carbon\Carbon::parse(\Carbon\Carbon::createFromTimestamp($plan_data['start_date'])->format('F Y'));
        $client = Client::create($client_data);
        $client->generateApiKey();
        $plan_data['client_id'] = $client->id;
        $client = $client->toArray();
        $plan = ServicePlan::create($plan_data);

        return compact('client');



    }

}