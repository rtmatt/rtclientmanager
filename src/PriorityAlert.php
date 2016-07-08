<?php

namespace RTMatt\MonthlyService;

use Illuminate\Database\Eloquent\Model;

class PriorityAlert extends Model
{

    protected $fillable = [
        "actual",
        "expected",
        "frequency",
        "user_device",
        "user_browser",
        "user_browser_ver",
        "contact_name",
        "contact_email",
        "contact_phone",
        "additional_info",
        "attachment",
        "client_id"
    ];


    public function client()
    {
        return $this->belongsTo('\RTMatt\MonthlyService\Client');
    }


    public static function create(array $attributes = [ ])
    {

        if (array_key_exists('attachment', $attributes)) {
            $attributes['attachment'] = static::processAttachment($attributes['attachment']);
        }

        return parent::create($attributes);
    }


    private static function processAttachment($attachment)
    {
        $extension          = $attachment->getClientOriginalExtension();
        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'gif'
        ];
        if ( ! in_array($extension, $allowed_extensions)) {
            return -1;
        }
        $path   = $attachment->getRealPath();
        $file   = \File::get($path);
        $base   = base64_encode($file);
        $base64 = "data:image/{$extension};base64,{$base}";

        return $base64;
    }


    public function decodeAttachment()
    {

        $split = explode(',',$this->attachment);
        $data= base64_decode($split[1]);
        return $data;
    }

}
