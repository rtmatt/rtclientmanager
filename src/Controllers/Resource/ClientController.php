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
use RTMatt\MonthlyService\ServicePlan;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::select('id', 'name')->get()->toArray();

        return json_encode($clients);
    }


    public function store(Request $request)
    {
        $client_data = $request->only('name', 'primary_contact_name', 'primary_contact_email', 'primary_contact_phone');
        $plan_data   = $request->only('hours_available_month', 'hours_available_year', 'standard_rate', 'start_date');

        $plan_data['start_date'] = \Carbon\Carbon::parse(\Carbon\Carbon::createFromTimestamp($plan_data['start_date'])->format('F Y'));
        $client                  = Client::create($client_data);
        $client->generateApiKey();
        $plan_data['client_id'] = $client->id;
        $client                 = $client->toArray();
        $plan                   = ServicePlan::create($plan_data);

        return compact('client');


    }


    public function destroy($client_id)
    {
        Client::archive($client_id);

        return response('Client Archived', 200);
    }


    public function getServicePlan($client_id){
        $client                   = Client::findOrFail($client_id);
        $plan                     = $client->service_plan()->select('id', 'start_date', 'hours_available_month',
            'hours_available_year', 'standard_rate')->first();
        $plan_array               = $plan->toArray();
        $plan_array['start_date'] = $plan->start_date->timestamp * 1000;

        return json_encode($plan_array);

    }
}