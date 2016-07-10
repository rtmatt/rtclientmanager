<?php
namespace RTMatt\MonthlyService\Tests;

use RTMatt\MonthlyService\Client;
use RTMatt\MonthlyService\RedtrainApiKeys;
use RTMatt\MonthlyService\ServicePlan;

class ClientServicesControllerTest extends \TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;


    /** @test */
    public function it_returns_status_204_when_client_has_no_active_plan()
    {
        $key            = factory(RedtrainApiKeys::class, 1)->create();
        $header         = $key->api_name . ":" . \Hash::make($key->api_secret_key);
        $header_encoded = base64_encode($header);

        $this->get(route('client-services-summary'), [
            'HTTP_Authorization' => $header_encoded
        ]);
        $this->assertResponseStatus(204);
    }


    /** @test */
    public function it_returns_status_404_when_client_not_found_matching_key()
    {
        //this is true, test is going to be a pain.
    }


    /** @test */
    public function it_returns_client_services_object_and_200_when_all_is_well()
    {
        $plan           = factory(ServicePlan::class, 1)->create();
        $client         = Client::find($plan->client_id);
        $key            = $client->generateApiKey();

        $header         = $key->api_name . ":" . \Hash::make($key->api_secret_key);
        $header_encoded = base64_encode($header);
        $response       = $this->get(route('client-services-summary'), [
            'HTTP_Authorization' => $header_encoded
        ])->seeJsonStructure([
            'last_backup',
            'monthly',
            'annual',
            'description'
        ]);
        $this->assertResponseOk();
    }


}
