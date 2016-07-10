<?php
namespace RTMatt\MonthlyService\Tests;
use Carbon\Carbon;

class ClientServiceReportTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    public function setUp()
    {
        parent::setUp();
        $plan_stub = $this->getMockBuilder('\RTMatt\MonthlyService\ServicePlan')->getMock();
        $plan_stub->method('getLastBackup')->willReturn(\Carbon\Carbon::now());
        $plan_stub->method('getDescription')->willReturn("This is the long text description of the plan");
        $months        = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        $report = $this->getMockBuilder('\RTMatt\MonthlyService\ClientAnnualUsageReport')->disableOriginalConstructor()->getMock();
        $report->name = 'Annual';
        $report->hours_available = 22;
        $report->hours_used = 2;
        $report->percentage_used = 2/22;
        $plan_stub->method('getAnnualReport')->willReturn($report);
        $month_reports = [ ];
        foreach ($months as $month) {
            $stub            = new \RTMatt\MonthlyService\ServiceMonth([ 'name' => $month,'start_date'=>Carbon::now() ]);
            $month_reports[] = $stub->getUsageReport();
        }
        $plan_stub->method('getMonthlyReports')->willReturn($month_reports);

        $this->client_report = new  \RTMatt\MonthlyService\ClientServiceReport($plan_stub);
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
    public function it_has_array_of_monthly_service_usages_for_month_data()
    {

        foreach ($this->client_report->monthly as $month) {
            $this->assertInstanceOf('\RTMatt\MonthlyService\ClientMonthUsageReport', $month);
        }
    }


    /** @test */
    public function it_returns_the_description_assigned_to_the_plan()
    {
        $this->assertEquals('This is the long text description of the plan', $this->client_report->description);
    }


}
