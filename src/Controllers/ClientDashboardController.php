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

class ClientDashboardController extends Controller
{

    public function getIndex()
    {

        $rt_client_ids = \RTMatt\MonthlyService\Client::lists('id');
        $id = rand(0,count($rt_client_ids)-1);
        $rt_client = \RTMatt\MonthlyService\Client::find($rt_client_ids[$id]);
        $key       = $rt_client->generateApiKey();
        $username  = $key->api_name;
        $password  = \Hash::make($key->api_secret_key);
        $client   = new Client([
            'base_uri' => 'http://dashboard.dev',
        ]);
        $response = $client->request('GET', route('client-services-summary'), [ 'auth' => [ $username, $password ] ]);
        $dashboard_data     = json_decode($response->getBody()->getContents());
        $client_id = $rt_client->id;
        $auth = base64_encode("{$username}:{$password}");
        return view('rtdashboard::dashboard', compact('dashboard_data','rt_client','client_id','auth'));


    }


    public function test($client_id){

        $rt_client = \RTMatt\MonthlyService\Client::find($client_id);
        $key       = $rt_client->generateApiKey();
        $username  = $key->api_name;
        $password  = \Hash::make($key->api_secret_key);
        $client   = new Client([
            'base_uri' => 'http://dashboard.dev',
        ]);
        $response = $client->request('GET', route('client-services-summary'), [ 'auth' => [ $username, $password ] ]);
        $dashboard_data     = json_decode($response->getBody()->getContents());
        $auth = base64_encode("{$username}:{$password}");
        return view('rtdashboard::dashboard', compact('dashboard_data','rt_client','client_id','auth'));
    }
}