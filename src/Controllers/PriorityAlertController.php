<?php
/**
 * Created by PhpStorm.
 * User: mattemrick
 * Date: 5/16/16
 * Time: 3:28 PM
 */

namespace RTMatt\MonthlyService\Controllers;


class PriorityAlertController extends \App\Http\Controllers\Controller{

    public function create(){
        return view('rtdashboard::temp-alertform');
    }


    public function index()
    {
        $alerts = \RTMatt\MonthlyService\PriorityAlert::all();
        return view('rtdashboard::temp-alertIndex',compact('alerts'));
    }


    public function store(\Illuminate\Http\Request $request){
        \RTMatt\MonthlyService\PriorityAlertProcessor::process($request->all());
        return redirect(route('alerts.index'));
    }



}