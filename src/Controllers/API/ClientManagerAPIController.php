<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 6/10/16
 * Time: 1:24 PM
 */

namespace RTMatt\MonthlyService\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RTMatt\MonthlyService\Client;

class ClientManagerAPIController extends Controller
{

    function __construct()
    {
        $this->middleware('web', [
            'except' => [
                'postRecordBackup',
            ]
        ]);
        $this->middleware('auth', [
            'except' => [
                'postRecordBackup',
            ]
        ]);
        $this->middleware('rtapi', [ 'only' => [ 'postRecordBackup' ] ]);
    }


    public function getTemplates($slug)
    {
        $view_slug = 'rtclientmanager::angular-templates.' . $slug;
        if (\View::exists($view_slug)) {
            return view($view_slug);
        }
        abort(404);
    }


    public function getClientDashboard($client_id = null)
    {
        if ( ! $client_id) {
            return null;
        }
        $client = \RTMatt\MonthlyService\Client::find($client_id);

        return view("rtclientdashboard::components.dashboard-component",
            [ 'dashboard_data' => $client->getServiceReport(), 'dashboard_id' => $client->id, 'admin_mode' => true ]);

    }


    public function postRecordBackup(Request $request)
    {
        $client_id = $request->input('client_id');

        $client = Client::find($client_id);
        if ($client) {
            $plan = $client->service_plan;
            $plan->update([
                'last_backup_datetime' => \Carbon\Carbon::now()
            ]);

            return response("Backup logged", 200);
        }
        return response("no client found",404);
    }
}