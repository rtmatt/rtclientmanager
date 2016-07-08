<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class ArchivedPlan extends Model
{
    protected $fillable = [
        'client_id',
        'hours_available_month',
        'hours_available_year',
        'standard_rate',
        'last_backup_datetime',
        'start_date',
        'description',
        'service_history'
    ];
}
