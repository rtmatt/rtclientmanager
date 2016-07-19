@extends($master_layout)
@section($layout_section)
    <div class="RT-Client-Manager" id="js--RT-Client-Manager-Wrap" ng-app="client-manager-app">
        <div class="RT-Client-Manager__row" ng-controller="clientManagerController as clientManager">
            <div class="RT-Client-Manager__clients">
                <div class="Client-Wrap" fixed-fill>
                    <div class="Client-Wrap__header clearfix">
                        <h2>Clients <small><a href="/{{config('rtclientmanager.client_manager_url')}}/priority-alerts">Alerts</a></small></h2>
                    </div>
                    <ul class="RT-Client-Manager__client-list">
                        <li ng-repeat="client in clients" ng-class="{active:clientManager.isActiveClient(client.id)}">
                            <a ng-click="clientManager.selectActiveClient(client.id)">
                                @{{ client.name }}
                            </a>
                        </li>
                    </ul>
                    <button class="RT-Dashboard-Form__button RT-Dashboard-Form__button--@{{ clientManager.addButtonClass }}" ng-click="clientManager.toggleAddMode()">@{{ clientManager.addButtonText }}</button>
                </div>
            </div>
            <div class="RT-Client-Manager__dashboards">
                <div class="RT-Client-Manager__add-client-wrap" ng-show="clientManager.addMode" >
                    <h2>Add Client</h2>
                    <div class="RT-Dashboard-Form RT-Dashboard-Form--add-client">
                        <form name="clientAddForm" ng-controller="clientAddController as clientAdd" novalidate>
                            <fieldset>
                                <legend>Client Info</legend>
                                <div class="RT-Dashboard-Form__row">
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':clientAddForm.client_name.$error.required && clientAdd.submitted}">
                                        <label class="control-label" for="">Name</label>
                                        <input required class="form-control" name="client_name" type="text" ng-model="clientAdd.formData.name"/>
                                        <span class="help-block" ng-show="clientAddForm.client_name.$error.required && clientAdd.submitted">Required!</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':clientAddForm.primary_contact_name.$error.required && clientAdd.submitted}">
                                        <label class="control-label" for="">Primary Contact Name</label>
                                        <input required name="primary_contact_name" class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_name"/>
                                        <span class="help-block" ng-show="clientAddForm.primary_contact_name.$error.required && clientAdd.submitted">Required!</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':clientAddForm.primary_contact_email.$error.required && clientAdd.submitted}">
                                        <label class="control-label" for="">Primary Contact Email</label>
                                        <input name="primary_contact_email" required class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_email"/>
                                        <span class="help-block" ng-show="clientAddForm.primary_contact_email.$error.required && clientAdd.submitted">Required!</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':clientAddForm.primary_contact_phone.$error.required && clientAdd.submitted}">
                                        <label class="control-label" for="">Primary Contact Phone</label>
                                        <input name="primary_contact_phone" required class="form-control" type="text" ng-model="clientAdd.formData.primary_contact_phone"/>
                                        <span class="help-block" ng-show="clientAddForm.primary_contact_phone.$error.required && clientAdd.submitted">Required!</span>
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend>Plan Info</legend>
                                <div class="RT-Dashboard-Form__row">
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':(clientAddForm.hours_available_month.$error.required ||clientAddForm.hours_available_month.$error.integer) && clientAdd.submitted}">
                                        <label class="control-label" for="">Monthly Flex Hours</label>
                                        <input name="hours_available_month" integer required class="form-control" type="text" ng-model="clientAdd.formData.hours_available_month"/>
                                        <span class="help-block" ng-show="clientAddForm.hours_available_month.$error.required && clientAdd.submitted">Required!</span>
                                        <span class="help-block" ng-show="clientAddForm.hours_available_month.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':(clientAddForm.hours_available_year.$error.required ||clientAddForm.hours_available_year.$error.integer) && clientAdd.submitted}">
                                        <label class="control-label" for="">Total Annual Hours</label>
                                        <input name="hours_available_year" integer required class="form-control" type="text" ng-model="clientAdd.formData.hours_available_year"/>
                                        <span class="help-block" ng-show="clientAddForm.hours_available_year.$error.required && clientAdd.submitted">Required!</span>
                                        <span class="help-block" ng-show="clientAddForm.hours_available_year.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" ng-class="{'has-error':(clientAddForm.standard_rate.$error.required ||clientAddForm.standard_rate.$error.integer) && clientAdd.submitted}">
                                        <label class="control-label" for="">Standard Hourly Rate</label>
                                        <input name="standard_rate" integer required class="form-control" type="text" ng-model="clientAdd.formData.standard_rate"/>
                                        <span class="help-block" ng-show="clientAddForm.standard_rate.$error.required && clientAdd.submitted">Required!</span>
                                        <span class="help-block" ng-show="clientAddForm.standard_rate.$error.integer && clientAdd.submitted">This has to be an integer</span>
                                    </div>
                                    <div class="RT-Dashboard-Form__col-tp-25 form-group" style="position:relative" ng-class="{'has-error':(clientAddForm.date.$error.required || clientAddForm.date.$error.moment) && clientAdd.submitted}">
                                        <label class="control-label" for="">First Billable Month</label>
                                        <input name="date" required monthpicker moment class="form-control" type="text" ng-model="clientAdd.formData.date"/>
                                        <span class="help-block" ng-show="clientAddForm.date.$error.required && clientAdd.submitted">Required!</span>
                                        <span class="help-block" ng-show="clientAddForm.date.$error.moment && clientAdd.submitted">Use the Datepicker to Pick a date</span>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="RT-Dashboard-Form__row Client-Form__actions">
                                <div class="RT-Dashboard-Form__col-tp-25">
                                    <button class="RT-Dashboard-Form__button RT-Dashboard-Form__button--success" ng-click="clientAdd.save(clientAddForm)">Save</button>
                                </div>
                                <div class="RT-Dashboard-Form__col-tp-25">
                                    <button class="RT-Dashboard-Form__button RT-Dashboard-Form__button--warning" ng-click="clientAdd.cancel()">Cancel</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="RT-Client-Manager__dashboard-list" ng-show="!clientManager.addMode">

                    <div ng-if="clientCollection.is_empty">
                        <h2>You have no clients.</h2>
                        <h3>:(</h3>
                        <button class="u--margin-top-30 RT-Dashboard-Form__button RT-Dashboard-Form__button--@{{ clientManager.addButtonClass }}" ng-click="clientManager.toggleAddMode()">Add one</button>
                    </div>
                    <section class="Client-Manager-Client"  ng-repeat="client in clients">

                        <div ng-controller="clientDashboardsController as dashboards">
                            <h1 class="Client-Manager-Client__heading">@{{client.name}}</h1>
                            <div ng-if="!dashboards.clientFullyLoaded()" class="RT-Client-Manager Dashboard-Loading">
                                <img class="Dashboard-Loading__image" src="/vendor/rtclientmanager/images/loading.svg" alt=""/>
                            </div>
                            <dashboard ng-show="dashboards.clientFullyLoaded()" id="client_dashboard_@{{client.id}}"></dashboard>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection