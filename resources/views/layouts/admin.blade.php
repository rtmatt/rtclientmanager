<!doctype html>
<html lang="en">
<head>
    <title> Admin Dashboard ::
        RedTrain Web Services
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='{{asset('vendor/rtclientmanager/css/client-manager.css')}}' rel='stylesheet'>
    <style>
        em{
            color: #808080;
        }
    </style>
</head>
<body class="">

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand clearfix" href="http://www.redtrainwebservices.com/admin">
                <img src="http://www.placehold.it/30x30" alt="Company Logo"
                     srcset="/images/admin-logo@1.5x.png 1.5x,/images/admin-logo@2x.png 2x,/images/admin-logo@3x.png 3x"
                     class="img-responsive">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="http://www.redtrainwebservices.com/admin/documentation">Documentation</a>
                </li>
                <li>
                    <a href="http://www.redtrainwebservices.com/admin">Dashboard</a>
                </li>
                <li>
                    <a href="http://www.redtrainwebservices.com/logout">Logout</a>
                </li>
                <li>
                    <a href="/" target="_blank">Main Site</a>
                </li>
                <li class="dropdown">
                </li>
                <li class="dropdown">
                </li>

                <li class="dropdown">
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="admin-wrapper">
    @yield('content')
</div>
<script src="{{asset('/vendor/rtclientmanager/js/client-manager.js')}}"></script>

</body>
</html>