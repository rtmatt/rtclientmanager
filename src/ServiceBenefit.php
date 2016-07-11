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


    public static function getDefaultBenefits(){
        return [
            [
                'icon'        => asset('/vendor/rtclientmanager/images/discount.svg'),
                'name'        => 'DISCOUNTED RATES',
                'description' => 'Save money on each service request and maximize your annual hours with 20% off the standard hourly rate.'
            ],
            [
                'icon'        => asset('/vendor/rtclientmanager/images/alerts.svg'),
                'name'        => 'PRIORITY SUPPORT',
                'description' => 'Access to our priority alert form gives you the highest priority turn-around times for all service requests and project needs.'
            ],
            [
                'icon'        => asset('/vendor/rtclientmanager/images/monthlyreports.svg'),
                'name'        => 'MONTHLY REPORTS',
                'description' => 'Receive detailed monthly statistics regarding your website tra c, marketing strategy, sales goals, and more.'
            ],
            [
                'icon'        => asset('/vendor/rtclientmanager/images/monitoring.svg'),
                'name'        => '24/7 MONITORING',
                'description' => 'We monitor, update, and maintain your website\'s server requirements and immediately respond to urgent noti cations.'
            ],
            [
                'icon'        => asset('/vendor/rtclientmanager/images/vps.svg'),
                'name'        => 'VIRTUAL PRIVATE SERVER',
                'description' => 'Professional Virtual Private Servers (VPS) enable faster speeds, greater security, and shorter development times.'
            ],
            [
                'icon'        => asset('/vendor/rtclientmanager/images/billing.svg'),
                'name'        => 'HASSLE-FREE BILLING',
                'description' => 'With one monthly invoice, don\'t stress over multiple service requests, budget constraints, or unwanted surprises.'
            ],

        ];
    }


}
