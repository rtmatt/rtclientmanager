<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/14/16
 * Time: 8:32 PM
 */

namespace RTMatt\MonthlyService\Controllers;

use App\Http\Controllers\Controller;
use RTMatt\MonthlyService\PriorityAlert;

class ClientManagerController extends Controller
{

    function __construct()
    {
       $this->middleware('auth');
    }


    public function getIndex()
    {
        $master_layout = 'layouts.admin';

        $clients = \RTMatt\MonthlyService\Client::all();

        if ( ! view()->exists($master_layout)) {
            $master_layout = 'rtclientmanager::layouts.admin';
        }
        $admin_mode = true;

        return view('rtclientmanager::manager.client-manager', compact('master_layout', 'clients', 'admin_mode'));
    }

}