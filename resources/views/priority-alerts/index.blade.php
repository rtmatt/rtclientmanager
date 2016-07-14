<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Priority Alerts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
        em{
            color: #808080;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Priority Alerts</h1>

    @if($alert_count>0)

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            @foreach($clients as $client)
                @if(count($client->priority_alerts)>0)
                    <li role="presentation" class="">
                        <a href="#client-{{$client->id}}" aria-controls="home" role="tab" data-toggle="tab">{{$client->name}}
                            <div class="badge">{{$client->priority_alerts()->count()}}</div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            @foreach($clients as $client)
                @if(count($client->priority_alerts)>0)
                    <div role="tabpanel" class="tab-pane" id="client-{{$client->id}}">
                        <div class="page-header">
                            <p class="lead">Priority Alerts For {{$client->name}}</p>
                        </div>
                        @foreach($client->priority_alerts as $alert)
                            <div class="panel panel-info">
                                <div class="panel-heading">{{$alert->created_at->diffForHumans()}}</div>
                                <div class="panel-body">


                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','actual'))}}</h3>
                                                    @if($alert->actual)
                                                        {{$alert->actual}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','expected'))}}</h3>
                                                    @if($alert->expected)
                                                        {{$alert->expected}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','frequency'))}}</h3>
                                                    @if($alert->frequency)
                                                        {{$alert->frequency}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','user_device'))}}</h3>
                                                    @if($alert->user_device)
                                                        {{$alert->user_device}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','user_browser'))}}</h3>
                                                    @if($alert->user_browser)
                                                        {{$alert->user_browser}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','user_browser_version'))}}</h3>
                                                    @if($alert->user_browser_ver)
                                                        {{$alert->user_browser_ver}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','contact_name'))}}</h3>
                                                    @if($alert->contact_name)
                                                        {{$alert->contact_name}}
                                                    @else
                                                        {{$client->primary_contact_name}}
                                                        <small>
                                                            <em>(Primary Contact)</em>
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','contact_email'))}}</h3>
                                                    @if($alert->contact_email)
                                                        {{$alert->contact_email}}
                                                    @else
                                                        {{$client->primary_contact_email}}
                                                        <small>
                                                            <em>(Primary Contact)</em>
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','contact_phone'))}}</h3>
                                                    @if($alert->contact_phone)
                                                        {{$alert->contact_phone}}
                                                    @else
                                                        {{$client->primary_contact_phone}}
                                                        <small>
                                                            <em>(Primary Contact)</em>
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','additional_info'))}}</h3>
                                                    @if($alert->additional_info)
                                                        {{$alert->additional_info}}
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="thumbnail">
                                                <div class="caption">
                                                    <h3 style="margin-top:0;">{{ucwords(str_replace('_',' ','attachment'))}}</h3>
                                                    @if($alert->attachment)
                                                        <a target="_blank" href="{{$alert->attachment}}">
                                                            <img class="img-responsive" src="{{$alert->attachment}}" alt=""/>
                                                        </a>
                                                    @else
                                                       <small> <em>(None Provided)</em></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            @endforeach
        </div>


    @else
        <h2>No priority alerts! Hooray!</h2>
    @endif</div>
</body>
</html>