var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    ////mix.phpUnit();
    /*
     |--------------------------------------------------------------------------
     | Build Client Manager Scripts
     |--------------------------------------------------------------------------
     */
    mix.scripts([
        './resources/assets/js/vendor/angular.min.js',
        './resources/assets/js/vendor/moment.js',
        './resources/assets/js/vendor/datetimepicker.js',
        //'./resources/assets/js/client-manager.js',
        './resources/assets/js/client-manager/*.js',
        './../rtclientdashboard/dist/js/dashboard.js'
    ], './dist/js/client-manager.js');

    /*
     |--------------------------------------------------------------------------
     | Build Client Manager Styles
     |--------------------------------------------------------------------------
     */
    mix.sass(['client-manager/client-manager.scss'], './dist/css/client-manager.css');

    /*
     |--------------------------------------------------------------------------
     | Copy files to project local for development purposes
     |--------------------------------------------------------------------------
     */
    mix.copy('dist/js/client-manager.js', '../../../public/vendor/rtclientmanager/js/client-manager.js');
    mix.copy('dist/js/client-manager.js.map', '../../../public/vendor/rtclientmanager/js/client-manager.js.map');
    mix.copy('dist/css/client-manager.css', '../../../public/vendor/rtclientmanager/css/client-manager.css');
    mix.copy('dist/css/client-manager.css.map', '../../../public/vendor/rtclientmanager/css/client-manager.css.map');


});