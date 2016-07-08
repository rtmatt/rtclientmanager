<?php
namespace RTMatt\MonthlyService\Tests;
use Carbon\Carbon;

class ServiceMonthTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    /** @test */


    //public function it_gets_available_hours_from_service_plan(){
    //  //todo
    //}

    /**
     * @test
     * @expectedException \RTMatt\MonthlyService\Exceptions\ServiceMonthNoDateException
     */
    public function it_throws_an_exception_when_trying_to_create_without_start_date(){
        $plan = factory(\RTMatt\MonthlyService\ServicePlan::class)->create();
        $month = \RTMatt\MonthlyService\ServiceMonth::create([
            'service_plan_id' => $plan->id,
            'client_id'       => $plan->client_id
        ]);
    }

    /** @test */
    public function it_generates_pretty_name_based_on_start_date(){
        $plan = factory(\RTMatt\MonthlyService\ServicePlan::class)->create();
        $month = \RTMatt\MonthlyService\ServiceMonth::create([
            'service_plan_id' => $plan->id,
            'client_id'       => $plan->client_id,
            'start_date'      => Carbon::now(),
        ]);

        $this->assertEquals(Carbon::now()->format('M'),$month->pretty_name);
    }


    /** @test
     * @expectedException \RTMatt\MonthlyService\Exceptions\ServiceMonthIncompatableStartDateException
     */
    public function it_throws_an_exception_when_trying_to_get_pretty_name_without_start_date(){
        $stub            = new \RTMatt\MonthlyService\ServiceMonth([ 'name' => str_random(5)]);
        $stub->getUsageReport();
    }

}