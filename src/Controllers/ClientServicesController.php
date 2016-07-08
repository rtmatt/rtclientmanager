<?php
namespace RTMatt\MonthlyService\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RTMatt\MonthlyService\Client;
use Validator;

class ClientServicesController extends Controller
{

    public function getIndex(Request $request)
    {
        $authorization = $request->header('authorization');
        list( $auth_name, $auth_key ) = \RTMatt\MonthlyService\Helpers\RTBasicAuthorizationParser::create($authorization)->getParsedValues();
        $client = Client::getByAPIName($auth_name);
        if ( ! $client) {
            return response('Unable to find client data for supplied API key', 404);
        }
        if ( ! $client->hasActivePlan()) {
            return response("Owner of API key does not have an active plan", 204);
        }
        $report              = $client->getServiceReport();
        $report->last_backup = $report->last_backup->diffForHumans();

        return json_encode($report);

    }


    public function postPriorityAlert(Request $request)
    {

        $this->validate($request, [
            'actual'        => 'required',
            'expected'      => 'required',
            'contact_email' => 'email'
        ], [
            'actual.required'     => 'Please tell us what\'s happening',
            'expected.required'   => 'Please tell us what should happen',
            'contact_email.email' => 'Please enter a valid email address we can use to contact you',

        ]);

        if($client = Client::getFromAuth($request->header('authorization'))){
            $request->merge(['client_id'=>$client->id]);
        }
        try{
            \RTMatt\MonthlyService\PriorityAlertProcessor::process($request->all());
        }catch(\Exception $e){
            
            return response('An error occurred processing the request',500);
        }

    }


    public function postIndex()
    {
        return "index put";
    }
}