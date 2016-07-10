<?php
namespace RTMatt\MonthlyService\Tests;

class ClientServiceIntegrationReportTest extends \TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;


    public function setUp()
    {
        parent::setUp();
        $this->client = factory(\RTMatt\MonthlyService\Client::class)->create();

        $this->plan = \RTMatt\MonthlyService\ServicePlan::create([
            'client_id'            => $this->client->id,
            'start_date'           => new \Carbon\Carbon('March 1, 2016'),
            'description'          => 'This is the plan description ' . str_random(10),
            'last_backup_datetime' => new \Carbon\Carbon('3 days ago'),
        ]);

        $this->client_report = new  \RTMatt\MonthlyService\ClientServiceReport($this->plan);

    }


    /** @test */
    public function it_has_scaffolded_the_test_properly()
    {
        $this->assertEquals(12, $this->plan->service_months->count());
    }


    /** @test */
    public function it_has_record_of_last_backup_in_carbon_format()
    {

        $this->assertTrue(property_exists($this->client_report, 'last_backup'));
        $this->assertInstanceOf('Carbon\Carbon', $this->client_report->last_backup);
    }


    /** @test */
    public function it_has_collection_of_month_data_for_12_months()
    {
        $this->assertTrue(property_exists($this->client_report, 'monthly'));
        $this->assertTrue(is_array($this->client_report->monthly));
        $this->assertCount(12, $this->client_report->monthly);
    }


    /** @test */
    public function it_contains_a_description_of_monthly_services_in_plain_text()
    {
        $this->assertTrue(property_exists($this->client_report, 'description'));
        $this->assertTrue(is_string($this->client_report->description));
        $this->assertEquals($this->plan->description, $this->client_report->description);
    }


    /** @test */
    public function it_has_record_of_annual_balance_usage_and_percentage_of_usage()
    {
        $this->assertTrue(property_exists($this->client_report, 'annual'));
        $this->assertTrue(property_exists($this->client_report->annual, 'hours_used'));
        $this->assertTrue(property_exists($this->client_report->annual, 'hours_available'));
        $this->assertTrue(property_exists($this->client_report->annual, 'percentage_used'));
    }


    /** @test */
    public function it_shows_proper_numbers_for_annual_usage_and_availability()
    {

        $plan = \RTMatt\MonthlyService\ServicePlan::create([
            'client_id'             => $this->client->id,
            'start_date'            => new \Carbon\Carbon('March 1, 2015'),
            'description'           => 'This is the plan description ' . str_random(10),
            'last_backup_datetime'  => new \Carbon\Carbon('3 days ago'),
            'hours_available_month' => 5,
            'hours_available_year'  => 45,

        ]);

        $used_hours = 0;
        //@todo: remove debugs
        foreach ($plan->service_months as $service_month) {
            $month_hours = rand(0, 5);
            // echo "\r\n\r\n".$month_hours . "used for ".$service_month->start_date->format('F');
            $used_hours += $month_hours;
            $service_month->update([
                'hours_used' => $month_hours
            ]);
        }
        $client_report = new  \RTMatt\MonthlyService\ClientServiceReport($plan);

        $this->assertEquals($used_hours, $client_report->annual->hours_used);
        $this->assertEquals(45, $client_report->annual->hours_available);
        $this->assertEquals($used_hours / 45 * 100, $client_report->annual->percentage_used);


    }


    /** @test */
    public function it_has_array_of_monthly_service_usages_for_month_data()
    {

        foreach ($this->client_report->monthly as $month) {
            $this->assertInstanceOf('\RTMatt\MonthlyService\ClientMonthUsageReport', $month);
        }
    }


    /** @test */
    public function it_returns_the_description_assigned_to_the_plan()
    {
        $this->assertEquals($this->plan->description, $this->client_report->description);
    }


    /** @test */
    public function it_shows_proper_numbers_for_monthly_usage_and_availability()
    {

        $plan = \RTMatt\MonthlyService\ServicePlan::create([
            'client_id'             => $this->client->id,
            'start_date'            => new \Carbon\Carbon('March 1, 2015'),
            'description'           => 'This is the plan description ' . str_random(10),
            'last_backup_datetime'  => new \Carbon\Carbon('3 days ago'),
            'hours_available_month' => 5,
            'hours_available_year'  => 45,

        ]);

        $used_hours  = 0;
        $month_usage = [ ];
        foreach ($plan->service_months as $service_month) {
            $month_hours = rand(0, 5);
            // echo "\r\n\r\n".$month_hours . "used for ".$service_month->start_date->format('F');
            $used_hours += $month_hours;
            $service_month->update([
                'hours_used' => $month_hours
            ]);
            $month_usage[$service_month->start_date->format('F')] = $month_hours;
        }
        $client_report = new  \RTMatt\MonthlyService\ClientServiceReport($plan);

        $this->assertTrue(is_array($client_report->monthly));
        foreach ($client_report->monthly as $month) {
            $this->assertInstanceOf('\RTMatt\MonthlyService\ClientMonthUsageReport', $month);
            $this->assertEquals($month_usage[$month->getReporter()->start_date->format('F')], $month->hours_used);
            $this->assertEquals(5, $month->hours_available);
            $this->assertEquals($month_usage[$month->getReporter()->start_date->format('F')] / 5 * 100,
                $month->percentage_used);
        }
    }


    /** @test */
    public function it_has_record_of_current_month()
    {
        $flag = 0;
        foreach ($this->client_report->monthly as $month) {
            if ($month->is_current_month == true) {
                $flag++;
            }
        }
        $this->assertEquals(1, $flag);
    }


}
