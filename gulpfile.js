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


//elixir(function (mix) {
//    mix.sass(['dashboard.scss'], 'dist/css/dashboard.css');
//    mix.scripts([
//        'resources/assets/js/vendor/parsleyjs.min.js',
//        'resources/assets/js/vendor/bs-modal-js.js',
//        'resources/assets/js/vendor/circles.min.js',
//        'resources/assets/js/dashboard.js'
//    ], 'dist/js/dashboard.js');
//
//    mix.copy('dist/js/dashboard.js', '../../public/js/dashboard.js');
//    mix.copy('dist/js/dashboard.js.map', '../../public/js/dashboard.js.map');
//    mix.copy('dist/css/dashboard.css', '../../public/css/dashboard.css');
//    mix.copy('dist/css/dashboard.css.map', '../../public/css/dashboard.css.map');
//});


elixir(function (mix) {




    ////mix.phpUnit();

    mix.scripts([
        './resources/assets/js/vendor/angular.min.js',
        './resources/assets/js/vendor/moment.js',
        './resources/assets/js/vendor/datetimepicker.js',
        './app/MonthlyService/resources/assets/js/client-manager/*.js'
    ], './dist/js/client-manager.js');

    mix.sass(['client-manager/client-manager.scss'],'./dist/css/client-manager.css');


    mix.copy('dist/js/client-manager.js', '../../../public/js/client-manager.js');
    mix.copy('dist/js/client-manager.js.map', '../../../public/js/client-manager.js.map');
    mix.copy('dist/css/client-manager.css', '../../../public/css/client-manager.css');
    mix.copy('dist/css/client-manager.css.map', '../../../public/css/client-manager.css.map');


});