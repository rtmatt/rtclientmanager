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

class PriorityAlertController extends Controller
{
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

}