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
use RTMatt\MonthlyService\ServiceBenefit;

class BenefitController extends Controller
{
    function __construct()
    {
        $this->middleware('web');
        $this->middleware('auth');
    }

    public function update(Request $request, ServiceBenefit $service_benefit)
    {
        $form_input = $request->all();
        if($file = $request->file('file')){
            $form_input = $this->saveFile($form_input, $file);
            \File::delete(public_path(trim($service_benefit->icon,'/')));
        }
        $service_benefit->update($form_input);
        return $service_benefit->toJson();
    }

    public function store(Request $request){
        $form_input = $request->only('name','description','service_plan_id');
        $file = $request->file('file');
        if($file){
            $form_input = $this->saveFile($form_input,$file);
        }
        $service_benefit = ServiceBenefit::create($form_input);

        return $service_benefit->toJson();


    }


    private function saveFile($form_input, $file)
    {
        $file_name = str_slug($form_input['name']) . str_random() . "_icon." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/benefits/'), $file_name);
        $form_input['icon'] = url('/uploads/benefits/' . $file_name);

        return $form_input;
    }
    public function destroy($id)
    {
        ServiceBenefit::destroy($id);

        return response('Benefit deleted', 200);
    }

}