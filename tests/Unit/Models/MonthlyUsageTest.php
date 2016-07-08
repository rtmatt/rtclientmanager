<?php
namespace RTMatt\MonthlyService\Tests;
use Carbon\Carbon;

class MonthUsageTest extends \TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
    public function setUp()
    {
        $this->stub = $this->getMockBuilder('\RTMatt\MonthlyService\ServiceMonth')->getMock();
        $this->stub->method('getAvailableHours')->willReturn(9);
        $this->stub->method('getHoursUsed')->willReturn(3);
        $this->stub->method('getServiceReportName')->willReturn('April');
        $carbon = Carbon::now()->subMonth();
        $this->stub->method('getStartDate')->willReturn($carbon);

    }

    /** @test */
    public function it_takes_an_instance_of_service_reporter(){
        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $this->assertInstanceOf('\RTMatt\MonthlyService\Contracts\ServiceReporter', $month_usage->getReporter());
    }

    /** @test */
    public function it_gets_name_from_reporter()
    {
        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $this->assertEquals('April',$month_usage->name);
    }

    /** @test */
    public function it_gets_hours_available_from_reporter(){

        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $this->assertEquals(9,$month_usage->hours_available);
    }

    /** @test */
    public function it_gets_hours_used_from_reporter(){

        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $this->assertEquals(3,$month_usage->hours_used);
    }
    
    /** @test */
    public function it_gets_percentage_of_hours_used(){
        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $ratio = 3/9 *100;
        $this->assertEquals($ratio,$month_usage->percentage_used);
    }

    /** @test */
    public function it_has_record_of_current_month(){
        $month_usage = new \RTMatt\MonthlyService\ClientMonthUsageReport($this->stub);
        $this->assertNotNull($month_usage->is_current_month);
    }


}