<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class RedtrainApiKeys extends Model
{

    public $fillable = [
        'api_secret_key',
        'client_id',
        'api_name'
    ];


    public static function byName($name)
    {
        return static::where('api_name', '=', $name)->get();
    }


    public function client()
    {
        return $this->belongsTo('\RTMatt\MonthlyService\Client');
    }
}
