<?php
namespace RTMatt\MonthlyService\Tests;

use Carbon\Carbon;

class ServicePlanTest extends \TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;


    /** @test
     * @expectedException \RTMatt\MonthlyService\Exceptions\ServicePlanNoDateException
     */
    public function it_throws_exception_when_created_with_no_date()
    {
        $client = factory(\RTMatt\MonthlyService\Client::class)->create();
        $plan   = \RTMatt\MonthlyService\ServicePlan::create([
            'last_backup_datetime' => \Carbon\Carbon::now(),
            'client_id'            => $client->id,
        ]);
        $this->assertEquals(1, 1);
    }


    /** @test */
    public function it_has_record_of_last_backup_in_carbon_format()
    {
        $client = factory(\RTMatt\MonthlyService\Client::class)->create();
        $plan   = \RTMatt\MonthlyService\ServicePlan::create([
            'last_backup_datetime' => \Carbon\Carbon::now(),
            'client_id'            => $client->id,
            'start_date'           => \Carbon\Carbon::now(),
        ]);
        $this->assertInstanceOf('\Carbon\Carbon', $plan->last_backup_datetime);
    }


    /** @test */
    public function it_has_linkage_to_client()
    {
        $plan = factory(\RTMatt\MonthlyService\ServicePlan::class)->create();
        $this->assertInstanceOf('\RTMatt\MonthlyService\Client', $plan->client);
    }


    /** @test */
    public function it_has_service_plan_description_in_plain_text()
    {
        $plan = factory(\RTMatt\MonthlyService\ServicePlan::class)->create();
        $this->assertTrue(is_string($plan->description));
    }


    /** @test */
    public function it_has_collection_of_twelve_months()
    {
        $plan = $this->scaffoldPlan();
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $plan->service_months);
        $this->assertEquals(12, $plan->service_months->count());
    }


    /** @test */
    public function it_creates_collection_of_twelve_months_upon_creation()
    {
        $plan = $this->scaffoldPlan();
        $this->assertEquals(12, $plan->service_months->count());
    }


    /** @test */
    public function it_creates_collection_of_months_starting_with_start_date_upon_creation()
    {
        $plan                    = $this->scaffoldPlan();
        $first_month_day_of_plan = new \Carbon\Carbon($plan->start_date->format('F') . '1 ,' . $plan->start_date->format('Y'));

        $this->assertEquals($first_month_day_of_plan, $plan->service_months[0]->start_date);
    }


    /** @test */
    public function it_creates_collection_of_twelve_months_containing_proper_start_dates_for_one_year()
    {
        $plan   = $this->scaffoldPlan([ 'start_date' => new Carbon('April 1, 2016') ]);
        $months = [
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
            'January',
            'February',
            'March'
        ];
        foreach ($plan->service_months as $index => $month) {
            $this->assertEquals($months[$index], $month->start_date->format('F'));
        }
    }


    /** @test */
    public function it_returns_array_of_service_month_report_objectss()
    {
        $plan    = $this->scaffoldPlan();
        $reports = $plan->getMonthlyReports();
        foreach ($reports as $report) {
            $this->assertInstanceOf('\RTMatt\MonthlyService\ClientMonthUsageReport', $report);
        }
    }


    /** @test */
    public function it_returns_last_backip_in_carbon_format()
    {
        $plan                       = $this->scaffoldPlan();
        $plan->last_backup_datetime = \Carbon\Carbon::now();
        $plan->save();
        $this->assertInstanceOf('\Carbon\Carbon', $plan->getLastBackup());
    }


    /** @test */
    public function it_creates_an_annual_usage_report()
    {
        $plan = $this->scaffoldPlan([
            'start_date'            => new \Carbon\Carbon('March 1, 2015'),
            'description'           => 'This is the plan description ' . str_random(10),
            'last_backup_datetime'  => new \Carbon\Carbon('3 days ago'),
            'hours_available_month' => 5,
            'hours_available_year'  => 45,
        ]);

        $used_hours          = 0;

        foreach ($plan->service_months as $service_month) {
            $month_hours = rand(0, 5);
            $used_hours += $month_hours;
            $service_month->hours_used = $month_hours;
            $service_month->save();
        }
        $annual_report = $plan->getAnnualReport();

        $this->assertEquals($used_hours, $annual_report->hours_used);
        $this->assertEquals(45, $annual_report->hours_available);
        $this->assertEquals($used_hours/45*100, $annual_report->percentage_used);


    }


    /**
     * @param $client
     *
     * @return static
     * @throws \RTMatt\MonthlyService\Exceptions\ServicePlanNoDateException
     */
    private function createPlan($client, $args = [ ])
    {
        $plan = \RTMatt\MonthlyService\ServicePlan::create([
            'client_id'             => $client->id,
            'hours_available_year'  => ! empty( $args['hours_available_year'] ) ? $args['hours_available_year'] : rand(6,
                12),
            'hours_available_month' => ! empty( $args['hours_available_month'] ) ? $args['hours_available_month'] : rand(1,
                5),
            'start_date'            => ! empty( $args['start_date'] ) ? $args['start_date'] : \Carbon\Carbon::now(),
            'description'           => ! empty( $args['description'] ) ? $args['description'] : str_random(200)
        ]);

        return $plan;
    }


    /**
     * @return ServicePlanTest
     */
    private function scaffoldPlan($args = [ ])
    {
        $client = factory(\RTMatt\MonthlyService\Client::class)->create();
        $plan   = $this->createPlan($client, $args);

        return $plan;
    }
}