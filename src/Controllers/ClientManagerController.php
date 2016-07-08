<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/14/16
 * Time: 8:32 PM
 */

namespace RTMatt\MonthlyService\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class ClientManagerController extends Controller
{

    public function getIndex()
    {
        $master_layout = 'layouts.admin';

        $clients = \RTMatt\MonthlyService\Client::all();

        if(!view()->exists($master_layout)){
            $master_layout = 'rtdashboard::layouts.admin';
        }
        $admin_mode=true;
        return view('rtdashboard::manager.client-manager',compact('master_layout','clients','admin_mode'));
    }
}