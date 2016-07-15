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
use RTMatt\MonthlyService\Client;
use RTMatt\MonthlyService\ServiceBenefit;
use RTMatt\MonthlyService\ServicePlan;

class ClientServicePlanBenefitController extends Controller
{

    function __construct()
    {
        $this->middleware(['web','auth']);
    }

    public function update(Request $request, $id)
    {
        $benefit    = ServiceBenefit::find($id);
        $form_input = $request->all();

        if ($file = $request->file('file')) {
            $form_input = $this->saveFile($form_input, $file);
            \File::delete(public_path(trim($benefit->icon, '/')));

        }
        $benefit->update($form_input);

        return $benefit->toJson();
    }


    public function store(Client $clients,ServicePlan $service_plan,Request $request)
    {

        $form_input = $request->only('name', 'description');
        $form_input['service_plan_id'] = $service_plan->id;
        $file       = $request->file('file');
        if ($file) {
            $form_input = $this->saveFile($form_input, $file);
        }
        $benefit = ServiceBenefit::create($form_input);

        return $benefit->toJson();


    }


    public function destroy($id)
    {
        ServiceBenefit::destroy($id);

        return response('Benefit deleted', 200);
    }


    /**
     * @param $form_input
     * @param $file
     *
     * @return mixed
     */
    private function saveFile($form_input, $file)
    {
        $file_name = str_slug($form_input['name']) . str_random() . "_icon." . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/benefits/'), $file_name);
        $form_input['icon'] = url('/uploads/benefits/' . $file_name);

        return $form_input;
    }
}