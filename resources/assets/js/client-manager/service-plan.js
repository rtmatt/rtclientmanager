(function () {
    "use strict";
    var clientManagerApp = angular.module('module-servicePlan', ['module-benefits']);
    /*  ====================
     Controllers
     ======================= */
    clientManagerApp.controller('clientPlanEditor', ['$scope', function ($scope) {
    }]);
    clientManagerApp.controller('clientDashboardPlanEditController', ['$scope', '$http', 'servicePlanFactory', function ($scope, $http, servicePlanFactory) {
        this.edit = function () {
            this.editMode = true;
        };
        this.selectMonth = function (moment_obj) {
            this.formData.active_month = {
                name: moment_obj.format('MMMM YYYY'),
                obj: moment_obj
            }

        }
        this.save = function () {


            if (confirm('Are you sure?  This will reset all usage statistics and start the client over with a new plan.')) {
                this.editMode = false;
                var url = '/api/client-manager/service-plan/' + $scope.client.service_plan.id;
                $http.put(url, this.formData).then(function (response) {
                    var new_plan_client_id = response.data.client_id;

                    $scope.client.service_plan = servicePlanFactory.new(new_plan_client_id, function () {
                        $scope.$parent.$broadcast('serviceHistoryChange');
                        //@todo: BIG CHANGE update dashboard display
                        $scope.client.dashboard_object.reset($scope.client.service_plan);
                    });

                });
            }
        };
        this.cancel = function () {
            this.formData = angular.copy(this.originalFormData);
            this.editMode = false;
        };
        this.__init = function () {

            this.editMode = false;

            this.formData = {
                hours_available_year: $scope.client.service_plan.hours_available_year,
                hours_available_month: $scope.client.service_plan.hours_available_month,
                standard_rate: $scope.client.service_plan.standard_rate
            };
            this.monthOptions = this.__getNewPlanMonths();
            this.__logOriginalInputValues();

        };
        this.__getNewPlanMonths = function () {

            var result = [];
            var plan_start_date = new Date($scope.client.service_plan.start_date);
            var start_month_option = {
                id: plan_start_date.getTime(),
                name: plan_start_date.toLocaleString('en-us', {month: "long", year: "numeric"})
            };

            for (var i = -6; i < 6; i++) {
                var date = new Date(plan_start_date.getFullYear(), plan_start_date.getMonth() + i)
                if (i == 0) {
                    result.push(start_month_option);
                    continue;
                }
                result.push(
                    {
                        id: date.getTime(),
                        name: date.toLocaleString('en-us', {month: "long", year: "numeric"})
                    }
                )
            }
            this.formData.active_month = start_month_option;
            return result;
        };
        this.__logOriginalInputValues = function () {
            this.originalFormData = angular.copy(this.formData);
        };

        this.__init();

    }]);
    clientManagerApp.controller('clientDashboardPlanLogController', ['$scope', '$interval', '$http', '$timeout', function ($scope, $interval, $http, $timeout) {
        var i = 0;
        var self = this;
        self.buttonText = 'Save';
        self.submitted = false;
        self.save_button_class = function () {
            if(self.submitting){
                return 'success';
            }
            if (self.submitted && $scope.clientUsageLogForm.$invalid) {
                return ' ';
            }
            return 'success';
        };
        function initializeData() {
            self.serviceMonths = angular.copy($scope.client.service_plan.service_history.months);
            self.formData = {
                active_month: self.serviceMonths.hasOwnProperty($scope.client.service_plan.service_history.active_month_id) ? self.serviceMonths[$scope.client.service_plan.service_history.active_month_id] : self.serviceMonths[0]
            };

            self.originalValue = self.formData.active_month.hasOwnProperty('hours_logged') ? self.formData.active_month.hours_logged : null;
        }

        this.changeActive = function () {
            this.originalValue = self.formData.active_month.hours_logged;
            this.resetButton();

        };
        var interval = $interval(function () {
            if (typeof $scope.client.service_plan.service_history.months !== 'undefined') {
                initializeData();
                $interval.cancel(interval);
            }
        }, 15);


        $scope.$on('serviceHistoryChange', function () {
            initializeData();
        });
        this.resetButton = function () {
            if (this.buttonText != 'Save') {
                this.buttonText = 'Save';
            }
        };
        this.saveLog = function () {
            self.submitted = true;
            console.log($scope.clientUsageLogForm);
            if ($scope.clientUsageLogForm.$valid) {
                self.submitting = true;
                //this will only allow you to save one at a time, rather than batch save
                self.buttonText = 'Saving...';
                self.buttonDisabled = true;
                var api_url = '/api/client-manager/service-plan/' + $scope.client.service_plan.id + "/log/" + self.formData.active_month.id;
                $http.put(api_url, self.formData.active_month).then(function (response) {
                    var value = self.formData.active_month.hours_logged;
                    var active_month_index = $scope.client.service_plan.service_history.getMonthIndex(self.formData.active_month.id);
                    var change = self.formData.active_month.hours_logged - self.originalValue;
                    var percent = self.formData.active_month.hours_logged / $scope.client.service_plan.hours_available_month * 100;
                    if (change != 0) {
                        $scope.client.dashboard_object.updateMonth(active_month_index, value);
                        //OLD VERSION WITH PROGRESSBAR
                        // $scope.client.dashboard_object.updateMonth(active_month_index, percent, value);
                        $scope.client.dashboard_object.updateAnnual(change);
                        self.originalValue = self.formData.active_month.hours_logged;
                    }
                    self.buttonText = 'Saved!';
                    var buttonTextTimeout = $timeout(function () {
                        self.buttonText = 'Save';
                        self.buttonDisabled = false;
                        self.submitted=false;
                        self.submitting = false;
                    }, 1500);

                    $scope.$on('$destroy', function () {
                        $timeout.cancel(buttonTextTimeout);
                    })

                });
            }
        };
    }]);


    /*  ====================
     SERVICES
     ======================= */
    clientManagerApp.service('serviceHistoryFactory', function ($http) {
        var ServiceHistory = function (service_plan_id, callback) {
            this.service_plan_id = service_plan_id;
            this.callback = callback;
            this.__initialize();
        };
        ServiceHistory.prototype = {
            __getMonths: function (service_plan_id, callback) {
                var months = {};
                var self = this;
                $http.get('/api/client-manager/service-plan/' + service_plan_id + '/history').then(function (response) {
                    months = response.data;
                    self.months = months;
                    if (typeof callback == "function") {
                        callback();
                    }
                });
            },
            getMonthIndex: function (month_id) {
                for (var i = 0; i < this.months.length; i++) {
                    if (this.months[i].id == month_id) {
                        return i;
                    }
                }
                return -1;
            },
            __calculateActiveMonth: function () {
                var now = new Date(Date.now());
                var nowstring = now.toLocaleString('en-us', {month: "long", year: "numeric"});
                var nowtime = Date.parse(nowstring);
                for (var i in this.months) {
                    var starttime = Date.parse(this.months[i].name);
                    if (starttime == nowtime) {
                        return i;
                    }
                }
                return -1;
            },
            __initialize: function () {
                var self = this;
                this.__getMonths(this.service_plan_id, function () {
                    self.active_month_id = self.__calculateActiveMonth();
                    if (typeof self.callback === 'function') {
                        self.callback();
                    }
                });
            }
        };
        return {
            new: function (service_plan_id, callback) {
                return new ServiceHistory(service_plan_id, callback);
            }
        }

    });
    clientManagerApp.service('servicePlanFactory', function (benefitCollection, serviceHistoryFactory, $http) {
        var ServicePlan = function (client_id, callback) {
            this.callback = callback;
            this.__getData(client_id);


        };

        ServicePlan.prototype = {
            __getData: function (client_id) {
                var self = this;
                var api_endpoint = "/api/client-manager/clients/" + client_id + "/service-plan";
                $http.get(api_endpoint).then(function (response) {
                    var data = response.data;
                    for (var i in data) {
                        self[i] = data[i];
                    }
                    self.service_history = serviceHistoryFactory.new(self.id, function () {
                        if (typeof self.callback == 'function') {
                            self.callback();
                        }
                    });
                    self.benefits = (benefitCollection.new(self.id));
                });
            },
            activeMonth: function () {
                for (var i = 0; i < this.months.length; i++) {
                    if (this.months[i].timestamp == new Date(2016, 2, 1).getTime()) {
                        return this.months[i].id
                    }
                }
            }
        };

        return {
            new: function (client_id, callback) {
                return new ServicePlan(client_id, callback);
            }
        };
    });


}());