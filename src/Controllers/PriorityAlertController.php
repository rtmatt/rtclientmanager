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
        $alert_count = PriorityAlert::count();
        $clients = \RTMatt\MonthlyService\Client::all();
        return view('rtclientmanager::priority-alerts.index',compact('clients','alert_count'));
    }


    public function store(\Illuminate\Http\Request $request){
        \RTMatt\MonthlyService\PriorityAlertProcessor::process($request->all());
        return redirect(route('alerts.index'));
    }



}