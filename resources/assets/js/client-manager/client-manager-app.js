(function (window) {
    window.Benefit = null;
    "use strict";
    var clientManagerApp = angular.module('client-manager-app', ['module-clients', 'module-servicePlan']).config(function ($httpProvider) {
        //@todo: configure middleware and auth for API
        // $httpProvider.defaults.headers.common.Authorization = 'Basic cmlkZWl0';
    });
    clientManagerApp.controller('clientDashboardsController', ['$scope', '$interval', 'benefitFactory',function ($scope, $interval,benefitFactory) {

        var self = this;
        var client = $scope.client;
        self.loaded = false;
        window.Benefit = benefitFactory.new({
            name:'benegit',
            description: "desc"
        });
        console.log(window.Benefit);
        this.clientFullyLoaded = function () {
            if (self.loaded) {
                return true;
            }
            if (client.dataLoaded && client.dashboardLoaded) {
                self.loaded = true;
                $scope.$broadcast('dataLoaded');
                return true;
            }
        }
    }]);

    clientManagerApp.controller('clientAddController',['$scope','$http','clientFactory','clientCollection',function($scope,$http,clientFactory,clientCollection){
        var self=this;
        this.submitted = false;
        this.cancel = function(){
            self.destroy();
        };

        $scope.benefits_batch=true;
        this.save = function(formObj){
            this.submitted = true;
            if($scope.clientAddForm.$valid){
                this.formData.start_date =this.formData.date.unix();
                $http.post('/api/client-manager/clients/',this.formData).then(function(response){
                    var client = response.data.client;
                    var client_obj = clientFactory.new(client.id,client.name,function(){
                        clientCollection.add(client_obj,function(){
                            $scope.$broadcast('newClientAdded',client_obj,function(result){
                                console.log('running callback');
                                client_obj.service_plan.benefits = result;
                            });
                            self.destroy();
                        });
                    });

                });
            }

        };
        this.destroy = function(){
            $scope.$parent.clientManager.addMode=false;
            self.formData={};
            $scope.clientAddForm.$setPristine();
            $scope.clientAddForm.$setSubmitted();
            this.submitted = false;
        };
    }]);
    clientManagerApp.controller('clientManagerController', ['$scope', 'clientCollection', function ($scope, clientCollection) {
        //TEMP TESTING SHITS
        //END TEMP TESTING
        $scope.loading = true;
        this.addMode = false;
        this.addClient = function(){
          this.addMode=true;
        };
        clientCollection.initialize(function () {
            $scope.clientCollection = clientCollection;
            $scope.clients = clientCollection.clients;
        });
        this.selectActiveClient = function (id) {
            var section = document.getElementById('client_dashboard_' + id);
            $("html, body").animate({
                scrollTop: section.offsetTop
            }, 300);
        };


    }]);
    clientManagerApp.directive('dashboard', function ($http, $compile,$timeout) {
        return {
            restrict: 'E',
            compile: function compile(tElement, tAttrs, transclude) {
                return {
                    pre: function preLink(scope, iElement, iAttrs, controller) {
                        var parent = iElement[0].parentNode;
                        $http.get('/api/client-manager/client-dashboard/' + scope.client.id).then(function (response) {
                            var wrap = document.createElement('div');
                            wrap.innerHTML = response.data;
                            iElement[0].appendChild(wrap);


                            //https://docs.angularjs.org/api/ng/service/$compile#example
                            scope.$watch(
                                function (scope) {
                                    return scope.$eval(iAttrs.compile);
                                },
                                function (value) {
                                    iElement.html(value);
                                    $compile(iElement.contents())(scope);
                                    scope.client.dashboardLoaded = true;
                                    controller.bindListeners();
                                }
                            );
                        });
                    }
                }
            },
            controller: function ($element, $scope) {
                this.client_id = +$scope.client.id;
                $scope.$on('dataLoaded', function () {
                    var animationTimeout = $timeout(function(){
                        $scope.client.dashboard_object.responsiveMonths();
                        $scope.client.dashboard_object.drawGraphs();
                    },150);
                    $scope.$on('destroy',function(){
                        $timeout.cancel(animationTimeout);
                    })

                });
                var self=this;

                this.bindListeners = function () {
                    $scope.client.dashboard_object = new ClientDashboard({
                        wrapper: 'js--Client-Dashboard_' + this.client_id,
                        delay: true,
                        id: this.client_id,
                        admin_mode:true
                    });
                    this.backupTextNode = $element[0].querySelector('.js--Last-Backup-Text');
                };
                this.replaceBackupText = function (s) {
                    this.backupTextNode.innerText = s;
                };
                this.logBackup = function () {
                    var url = "/api/client-manager/service-plan/"+$scope.client.service_plan.id+"/backup";
                    this.replaceBackupText('Saving...');
                    $http.put(url,{
                        timestamp: Date.now()
                    }).then(function(response){
                       var newTime = response.data.backup_datetime;
                        self.replaceBackupText(newTime);
                    });
                }
            },
            controllerAs: 'clientDashboardController'
        }
    });

    clientManagerApp.directive('monthpicker', function () {
        return {
            restrict: "A",
            require: 'ngModel',
            link: function (scope, element, attrs, ngModelCtrl) {
                $(function () {
                    element.datetimepicker({
                        defaultDate: null,
                        viewMode: "months",
                        format: 'MMMM YYYY'
                    });
                    element.on('dp.hide', function () {
                        ngModelCtrl.$setViewValue(element.data('DateTimePicker').date());
                    });
                });
            }
        };
    });


    var INTEGER_REGEXP = /^\-?\d+$/;
    clientManagerApp.directive('integer', function() {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                ctrl.$validators.integer = function(modelValue, viewValue) {
                    if (ctrl.$isEmpty(modelValue)) {
                        // consider empty models to be valid
                        return true;
                    }

                    if (INTEGER_REGEXP.test(viewValue)) {
                        // it is valid
                        return true;
                    }

                    // it is invalid
                    return false;
                };
            }
        };
    });
    clientManagerApp.directive('moment', function() {
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                ctrl.$validators.moment = function(modelValue, viewValue) {

                    if (ctrl.$isEmpty(modelValue)) {
                        // consider empty models to be valid
                        return true;
                    }

                    if (modelValue._isAMomentObject===true) {

                        return true;
                    }

                    // it is invalid
                    return false;
                };
            }
        };
    });



}(window));





