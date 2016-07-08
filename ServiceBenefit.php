<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class ServiceBenefit extends Model
{

    protected $visible = [ 'description', 'icon', 'name', 'id' ];

    protected $fillable = [
        'service_plan_id',
        'icon',
        'name',
        'description'

    ];

}
