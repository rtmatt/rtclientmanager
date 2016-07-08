<style>
    *{
        font-size:14px;
        margin:0;
    }
    dt{
        font-weight:bold;
    }
    dd{
        margin-left:15px;
    }
    body{
        padding:0 0 0 20px;
    }
    section{
        margin:30px 0;
    }
</style>
@foreach($alerts as $alert)

    <fieldset>
        <legend>Alert {{$alert->id}}</legend>
       <dl>
           @if($alert->client)
           <dt>Client</dt>
           <dd> {{$alert->client->name}}</dd>
           @endif
           <dt>id</dt>
           <dd>{{$alert->id}}</dd>
           <dt>created_at</dt>
           <dd>{{$alert->created_at}}</dd>
           <dt>updated_at</dt>
           <dd>{{$alert->updated_at}}</dd>
           <dt>actual</dt>
           <dd>{{$alert->actual}}</dd>
           <dt>expected</dt>
           <dd>{{$alert->expected}}</dd>
           <dt>frequency</dt>
           <dd>{{$alert->frequency}}</dd>
           <dt>user_device</dt>
           <dd>{{$alert->user_device}}</dd>
           <dt>user_browser</dt>
           <dd>{{$alert->user_browser}}</dd>
           <dt>user_browser_ver</dt>
           <dd>{{$alert->user_browser_ver}}</dd>
           <dt>contact_name</dt>
           <dd>{{$alert->contact_name}}</dd>
           <dt>contact_email</dt>
           <dd>{{$alert->contact_email}}</dd>
           <dt>contact_phone</dt>
           <dd>{{$alert->contact_phone}}</dd>
           <dt>additional_info</dt>
           <dd>{{$alert->additional_info}}</dd>
           <dt>attachment</dt>
           <dd> <img style="max-width:25%;" src="{{$alert->attachment}}"></dd>
       </dl>
    </fieldset>
@endforeach




