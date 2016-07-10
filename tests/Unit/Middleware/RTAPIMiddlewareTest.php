<?php
namespace RTMatt\MonthlyService\Tests;

class RTAPIMiddlewareTest extends \TestCase
{

    protected $summaryUri;


    public function setUp()
    {
        parent::setUp();
        $this->summaryUri = route('client-services-summary');
    }


    /** @test */
    public function it_returns_unauthorized_error_for_requests_with_no_token()
    {

        $response = $this->call('GET', $this->summaryUri);
        $this->assertResponseStatus(401);
    }


    /** @test */
    public function it_returns_forbidden_code_when_bad_credentials_sent()
    {
        $res = $this->get($this->summaryUri, [
            'HTTP_Authorization' => str_random(20)
        ]);
        $this->assertResponseStatus(403);
    }

    //@todo: start from here
    /** @test */
    public function it_lets_authorized_authentication_combinations_through(){
        config(['monthlyserice.guard'=>\RTMatt\MonthlyService\Tests\Helpers\PassingGuard::class]);

        $res = $this->get($this->summaryUri, [
            'HTTP_Authorization' => str_random(20)
        ])->dontSee('Get outta here with that unauthenticated crap.')->dontSee('You ain\'t provided the correct authentication shits');
        
    }

    ///** @test */
    //public function it_includes_matched_client_in_request(){
    //    $this->assertTrue(false);
    //}

}