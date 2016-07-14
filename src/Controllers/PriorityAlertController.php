<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/16/16
 * Time: 3:28 PM
 */

namespace RTMatt\MonthlyService\Controllers;


use RTMatt\MonthlyService\PriorityAlert;

class PriorityAlertController extends \App\Http\Controllers\Controller{

    public function create(){
        return view('rtclientmanager::temp-alertform');
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


    public function store(\Illuminate\Http\Request $request){
        \RTMatt\MonthlyService\PriorityAlertProcessor::process($request->all());
        return redirect(route('alerts.index'));
    }



}