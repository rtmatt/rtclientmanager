<?php
namespace RTMatt\MonthlyService\Tests;

use RTMatt\MonthlyService\Client;
use RTMatt\MonthlyService\RedtrainApiKeys;
use RTMatt\MonthlyService\ServicePlan;

class ClientTest extends \TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;


    /** @test */
    public function it_can_save_and_retrieve_name_contact_info_and_api_key()
    {
        $fields = $this->getFields();
        $client = $this->createClient($fields);
        foreach ($fields as $key => $val) {
            $this->assertEquals($val, $client->$key);
        }
    }


    /** @test */
    public function it_can_retrieve_its_own_report_or_statically()
    {
        $client                  = $this->createClient();
        $plan                    = factory(ServicePlan::class)->create([ 'client_id' => $client->id ]);
        $client_retrieved_report = $client->getServiceReport();
        $this->assertInstanceOf('\RTMatt\MonthlyService\ClientServiceReport', $client_retrieved_report);
        $static_report = Client::serviceReport($client->id);
        $this->assertInstanceOf('\RTMatt\MonthlyService\ClientServiceReport', $static_report);
        $this->assertEquals($client_retrieved_report, $static_report);
    }


    /** @test */
    public function it_can_retrieve_its_plan()
    {
        $client   = $this->createClient();
        $plan     = factory(ServicePlan::class)->create([ 'client_id' => $client->id ]);
        $plan_obj = ServicePlan::find($plan->id);
        $this->assertEquals($client->service_plan, $plan_obj);
    }


    private function getFields($attributes = [ ])
    {
        $name                  = array_key_exists('name', $attributes) ? $attributes['name'] : "Client";
        $primary_contact_name  = array_key_exists('primary_contact_name',
            $attributes) ? $attributes['primary_contact_name'] : "Contact";
        $primary_contact_email = array_key_exists('primary_contact_email',
            $attributes) ? $attributes['primary_contact_email'] : "test@test.com";
        $primary_contact_phone = array_key_exists('primary_contact_phone',
            $attributes) ? $attributes['primary_contact_phone'] : "555-555-5555";

        $fields                = compact('name', ' primary_contact_name', ' primary_contact_email',
            'primary_contact_phone');

        return $fields;
    }


    /** @test */
    public function it_can_tell_if_a_client_has_an_active_plan()
    {
        $plan   = factory(ServicePlan::class, 1)->create();
        $client = $plan->client;
        $this->assertTrue($client->hasActivePlan());
        $client2 = factory(Client::class, 1)->create();
        $this->assertFalse($client2->hasActivePlan());
        $plan->update([ 'is_active' => 0 ]);
        $this->assertFalse($client->hasActivePlan());

    }


    /** @test */
    public function it_can_genrate_an_api_key(){
        $client = factory(Client::class,1)->create();
       $key =  $client->generateApiKey();
        $this->assertInstanceOf('\RTMatt\MonthlyService\RedtrainApiKeys',$key);
        $this->assertInstanceOf('\RTMatt\MonthlyService\RedtrainApiKeys',$client->api_key);
        $this->assertEquals($key->id,$client->api_key->id);

    }
    
    /** @test */
    public function it_replaces_existing_api_key_when_a_new_one_is_made(){
        $client = factory(Client::class,1)->create();
        $key =  $client->generateApiKey();
        $client->generateApiKey();
        $this->assertNotEquals($key->id,$client->api_key->id);
        $this->assertEquals(1,$client->api_key()->count());
    }


    /**
     * @param $fields
     *
     * @return static
     */
    private function createClient($attributes = [ ])
    {
        $fields = $this->getFields($attributes);
        $client = \RTMatt\MonthlyService\Client::create($fields);

        return $client;
    }
}