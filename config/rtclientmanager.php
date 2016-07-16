<?php

return [
    'guard' => \RTMatt\MonthlyService\Middleware\RTAPIGuard::class,
    'client_manager_url' => 'client-manager',
    'layout_file'=>'layouts.admin',
    'layout_section'=>'content'
    //@todo: this is where config for registering the dashboard in the servide provider would live
];