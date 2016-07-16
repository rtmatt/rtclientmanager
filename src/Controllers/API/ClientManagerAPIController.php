<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 6/10/16
 * Time: 1:24 PM
 */

namespace RTMatt\MonthlyService\Controllers\API;

use App\Http\Controllers\Controller;

class ClientManagerAPIController extends Controller
{

    function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
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

}