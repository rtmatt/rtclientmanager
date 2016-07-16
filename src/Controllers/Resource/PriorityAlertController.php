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
use RTMatt\MonthlyService\PriorityAlert;


class PriorityAlertController extends Controller
{

    function __construct()
    {


        $this->middleware('web',['only'=>['index']]);
        $this->middleware('auth',['only'=>['index']]);

        $this->middleware('rtapi', [ 'only' => [ 'store' ] ]);

    }


    public function index()
    {
        $master_layout = 'layouts.admin';


        if(!view()->exists($master_layout)){
            $master_layout = 'rtclientmanager::layouts.admin';
        }

        $alert_count = PriorityAlert::count();
        $clients = \RTMatt\MonthlyService\Client::all();
        return view('rtclientmanager::priority-alerts.index',compact('clients','alert_count','master_layout'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'actual'        => 'required',
            'expected'      => 'required',
            'contact_email' => 'email',
            'attachment'    => 'image'
        ], [
            'actual.required'     => 'Please tell us what\'s happening',
            'expected.required'   => 'Please tell us what should happen',
            'contact_email.email' => 'Please enter a valid email address we can use to contact you',
            'attachment.image'    => 'Please only attach images in a valid format (jpg, jpeg, png, gif)'

        ]);

        if ($client = Client::getFromAuth($request->header('authorization'))) {
            $request->merge([ 'client_id' => $client->id ]);
        }
        try {
            \RTMatt\MonthlyService\PriorityAlertProcessor::process($request->all());
        } catch (\Exception $e) {
            dd($e);
            return response('An error occurred processing the request', 500);
        }

        return response("Alert processed", 200);
    }
}