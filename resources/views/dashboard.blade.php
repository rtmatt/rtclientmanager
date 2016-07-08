<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Client Dashboard</title>

    <!-- Stylesheets -->
    <link href='/css/dashboard.css' rel='stylesheet'>
</head>
<body>
<ul class="nav nav-tabs">
    @foreach(\RTMatt\MonthlyService\Client::all() as $client)
        <li role="presentation"{!!$client->id==$client_id ? ' class="active"':''!!}><a href="/clients/test/{{$client->id}}">{{$client->name}}</a></li>
    @endforeach
</ul>

<h1>Dashboard for {{$rt_client->name}}</h1>

@include('rtdashboard::components.dashboard-component')



<!-- Scripts -->
<script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
<!--<script src='js/app.js'></script>-->
<script src='/js/dashboard.js'></script>
<script>
//    jQuery(document).ready(function(){
        new ClientDashboard({
            auth:'{{$auth}}'
        });
//    });
</script>

</body>
</html>
