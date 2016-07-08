<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = [
        'name',
        'primary_contact_name',
        'primary_contact_email',
        'primary_contact_phone',
        'api_key',
    ];

    protected $visible = [
        'id',
        'name',
        'primary_contact_name',
        'primary_contact_email',
        'primary_contact_phone'
    ];


    public function service_plan()
    {
        return $this->hasOne('\RTMatt\MonthlyService\ServicePlan');
    }


    public function getServiceReport()
    {
        return new ClientServiceReport($this->service_plan);
    }


    public static function serviceReport($client_id)
    {
        $client = Client::findOrFail($client_id);

        return $client->getServiceReport();

    }


    public function hasActivePlan()
    {

        $plans = $this->service_plan()->get();

        if (count($plans) > 0) {
            return true;
        }

        return false;

    }


    public function api_key()
    {
        return $this->hasOne('\RTMatt\MonthlyService\RedtrainApiKeys');
    }


    public function generateApiKey()
    {

        if ($key = $this->api_key()->first()) {

            $key->delete();
        }
        $name = strtolower(str_slug($this->name));
        $key  = uniqid();

        return RedtrainApiKeys::create([
            'api_secret_key' => $key,
            'api_name'       => $name,
            'client_id'      => $this->id
        ]);
    }


    public static function getByAPIName($api_name)
    {
        $api_key_object = RedtrainApiKeys::where('api_name', '=', $api_name)->first();

        if ( ! $api_key_object) {
            return null;
        }

        return $api_key_object->client;
    }


    public static function getFromAuth($auth_header)
    {
        $parsed_auth = \RTMatt\MonthlyService\Helpers\RTBasicAuthorizationParser::create($auth_header);
        $auth_name   = $parsed_auth->auth_name;

        return static::getByAPIName($auth_name);
    }

}
