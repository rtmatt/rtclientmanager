<?php
namespace RTMatt\MonthlyService\Tests\Helpers;

use RTMatt\MonthlyService\Contracts\RTGuardContract;

class PassingGuard implements RTGuardContract
{

    public function check($authorization_input)
    {
        return true;
    }
}



