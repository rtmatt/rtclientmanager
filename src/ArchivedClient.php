<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class ArchivedClient extends Model
{

    protected $fillable = [
        'name',
        'primary_contact_name',
        'primary_contact_email',
        'primary_contact_phone',
        'archived_plans'
    ];
}
