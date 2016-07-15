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
use RTMatt\MonthlyService\ServiceMonth;

class ServiceMonthController extends Controller
{
    function __construct()
    {
        $this->middleware(['web','auth']);
    }
    
    public function update(ServiceMonth $service_month,Request $request){
        $input['hours_used']  = $request->input('hours_logged');
        $input['description'] = $request->input('description');

        $service_month->update($input);

        return $service_month->toJson();
    }

}