@extends($master_layout)
@section('content')

    <link href='/css/client-manager.css' rel='stylesheet'>
    <div class="RT-Client-Manager" id="js--RT-Client-Manager-Wrap" ng-app="client-manager-app">
        <div class="RT-Client-Manager__row" ng-controller="clientManagerController as clientManager">
            <div class="RT-Client-Manager__clients">
                <div class="Client-Wrap" fixed-fill>
                    <div class="Client-Wrap__header clearfix">
                        <h2>Clients</h2>

                    </div>
                    <ul class="RT-Client-Manager__client-list">
                        <li ng-repeat="client in clients" ng-class="{active:clientManager.isActiveClient(client.id)}">
                            <a ng-click="clientManager.selectActiveClient(client.id)">
                                @{{ client.name }}
                            </a>
                        </li>
                    </ul>
                    <button class="RT-Dashboard-Form__button RT-Dashboard-Form__button--info" ng-click="clientManager.addClient()">Add</button>
                </div>
            </div>
            <div class="RT-Client-Manager__dashboards">
                <div ng-show="clientManager.addMode">
                    <h2>Add Client</h2>
                    <div>
                        <form name="clientAddForm" ng-controller="clientAddController as clientAdd" novalidate>
                            <fieldset>
                                <legend>Client Info</legend>
                                <div class="form-group" ng-class="{'has-error':clientAddForm.client_name.$error.required && clientAdd.submitted}">
                                    <label class="control-label" for="">Name</label>
                                    <input required class="form-control" name="client_name" type="text" ng-model="clientAdd.formData.name"/>
                                    <span class="help-block" ng-show="clientAddForm.client_name.$error.required && clientAdd.submitted">Required!</span>
                                </div>
                                <div class="form-group" ng-class="{'has-error':clientAddForm.primary_contact_name.$error.required && clientAdd.submitted}">
                                    <label class="control-label" for="">Primary Contact Name</label>
                                    <input required name="primary_contact_name" class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_name"/>
                                    <span class="help-block" ng-show="clientAddForm.primary_contact_name.$error.required && clientAdd.submitted">Required!</span>
                                </div>
                                <div class="form-group" ng-class="{'has-error':clientAddForm.primary_contact_email.$error.required && clientAdd.submitted}">
                                    <label class="control-label" for="">Primary Contact Email</label>
                                    <input name="primary_contact_email" required class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_email"/>
                                    <span class="help-block" ng-show="clientAddForm.primary_contact_email.$error.required && clientAdd.submitted">Required!</span>
                                </div>
                                <div class="form-group" ng-class="{'has-error':clientAddForm.primary_contact_phone.$error.required && clientAdd.submitted}">
                                    <label class="control-label" for="">Primary Contact Phone</label>
                                    <input name="primary_contact_phone" required class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_phone"/>
                                    <span class="help-block" ng-show="clientAddForm.primary_contact_phone.$error.required && clientAdd.submitted">Required!</span>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Plan Info</legend>
                                <div class="form-group" ng-class="{'has-error':(clientAddForm.hours_available_month.$error.required ||clientAddForm.hours_available_month.$error.integer) && clientAdd.submitted}">
                                    <label class="control-label" for="">Hours Available Month</label>
                                    <input name="hours_available_month" integer required class="form-control" type="text" ng-model="clientAdd.formData.hours_available_month"/>
                                    <span class="help-block" ng-show="clientAddForm.hours_available_month.$error.required && clientAdd.submitted">Required!</span>
                                    <span class="help-block" ng-show="clientAddForm.hours_available_month.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                </div>
                                <div class="form-group" ng-class="{'has-error':(clientAddForm.hours_available_year.$error.required ||clientAddForm.hours_available_year.$error.integer) && clientAdd.submitted}">
                                    <label class="control-label" for="">Hours Available Year</label>
                                    <input name="hours_available_year" integer required class="form-control" type="text" ng-model="clientAdd.formData.hours_available_year"/>
                                    <span class="help-block" ng-show="clientAddForm.hours_available_year.$error.required && clientAdd.submitted">Required!</span>
                                    <span class="help-block" ng-show="clientAddForm.hours_available_year.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                </div>
                                <div class="form-group" ng-class="{'has-error':(clientAddForm.standard_rate.$error.required ||clientAddForm.standard_rate.$error.integer) && clientAdd.submitted}">
                                    <label class="control-label" for="">Standard Rate</label>
                                    <input name="standard_rate" integer required class="form-control" type="text" ng-model="clientAdd.formData.standard_rate"/>
                                    <span class="help-block" ng-show="clientAddForm.standard_rate.$error.required && clientAdd.submitted">Required!</span>
                                    <span class="help-block" ng-show="clientAddForm.standard_rate.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                </div>
                                <div class="form-group" style="position:relative" ng-class="{'has-error':(clientAddForm.date.$error.required || clientAddForm.date.$error.moment) && clientAdd.submitted}">
                                    <label class="control-label" for="">Start Date</label>
                                    <input name="date" required monthpicker moment class="form-control" type="text" ng-model="clientAdd.formData.date"/>
                                    <span class="help-block" ng-show="clientAddForm.date.$error.required && clientAdd.submitted">Required!</span>
                                    <span class="help-block" ng-show="clientAddForm.date.$error.moment && clientAdd.submitted">Use the Datepicker to Pick a date</span>
                                </div>

                            </fieldset>
                            <benefits></benefits>
                            <fieldset>
                                <button class="btn btn-primary" ng-click="clientAdd.save(clientAddForm)">Save</button>
                                <button class="btn btn-primary" ng-click="clientAdd.cancel()">Cancel</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <section ng-show="!clientManager.addMode" ng-repeat="client in clients">
                    <div ng-controller="clientDashboardsController as dashboards">
                        <h1>@{{client.name}}</h1>
                        <div ng-if="!dashboards.clientFullyLoaded()" class="RT-Client-Manager Dashboard-Loading">
                            <img class="Dashboard-Loading__image" src="/images/loading.svg" alt=""/>
                        </div>
                        <dashboard ng-show="dashboards.clientFullyLoaded()" id="client_dashboard_@{{client.id}}"></dashboard>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{asset('js/client-manager.js')}}"></script>
    {{--<script src='/js/dashboard.js'></script>--}}

@endsection