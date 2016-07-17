<?php

return [
    'guard' => \RTMatt\MonthlyService\Middleware\RTAPIGuard::class,
    'client_manager_url' => 'client-manager',
    'layout_file'=>'layouts.admin',
    'layout_section'=>'content',
    'notification_email'=>[
        'name'=>env('RTDB_HOME_EMAIL_NAME','DESIGNLEDGE Team'),
        'email'=>env('RTDB_HOME_EMAIL','team@designledge.com'),
    ],
    'notification_email_cc'=>[
        'name'=>env('RTDB_HOME_EMAIL_NAME_CC',null),
        'email'=>env('RTDB_HOME_EMAIL_CC',null),
    ],
    'notification_email_origin'=>[
        'name'=>env('RTDB_ORIGIN_EMAIL_NAME','DESIGNLEDGE'),
        'email'=>env('RTDB_ORIGIN_EMAIL','noreply@designledge.com'),
    ]

    //@todo: this is where config for registering the dashboard in the servide provider would live
];