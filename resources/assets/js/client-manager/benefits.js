(function () {
    "use strict";
    var clientManagerApp = angular.module('module-benefits', ['ngFileUpload']);
    clientManagerApp.controller('benefitEditorController', ['$scope', '$http', 'Upload', function ($scope, $http, Upload) {
        this.editMode = false;
        this.benefit = $scope.benefit;
        var self = this;
        this.edit = function () {
            this.editMode = true;
            this.origionalBenefit = angular.copy(this.benefit);
        };
        this.delete = function () {
            var api_url = '/api/client-manager/benefits/' + $scope.benefit.id;
            $http.delete(api_url).then(function (response) {
                //@todo:is there anything else we need to do here?
                $scope.client.service_plan.benefits.remove($scope.benefit.id);
            });
        };
        this.save = function () {
            var api_url = '/api/client-manager/benefits/' + $scope.benefit.id;
            var formData = $scope.benefit;
            formData.file = $scope.benefit.file;
            formData._method = "PUT";
            Upload.upload({
                    url: api_url,
                    data: formData
                }
            ).then(function success(response) {
                    $scope.benefit = response.data;
                    self.benefit = $scope.benefit;

                    self.editMode = false;
                }, function error(response) {
                }, function event(response) {
                });
        };
        this.cancel = function () {
            this.editMode = false;
            $scope.benefit = angular.copy(this.origionalBenefit);
        }
    }]);
    clientManagerApp.service('benefitCollection', function (benefitFactory, $http) {
        var BenefitCollection = function (service_plan_id) {
            this.service_plan_id = service_plan_id;
            this.isBenefitCollection = true;
            this.isInitialized = false;
            var self = this;
            this.__initialize();
        };
        BenefitCollection.prototype = {
            __initializeBenefits: function () {
                var self = this;
                var api_endpoint = '/api/client-manager/service-plan/' + this.service_plan_id + '/benefits';
                $http.get(api_endpoint).then(function (response) {
                    self.benefits = {};
                    for (var i in response.data) {
                        self.benefits[response.data[i].id] = response.data[i];
                    }
                    self.isInitialized = true;
                });
            },
            __initialize: function (callback) {
                this.benefits = {};
                this.__initializeBenefits();
                if (typeof callback == 'function') {
                    callback();
                }
            },
            add: function (Benefit, callback) {

                this.benefits[Benefit.id] = Benefit;

                if (typeof callback == 'function') {
                    callback();
                }
            },
            find: function (id) {
                return (this.benefits.hasOwnProperty(id)) ? this.benefits[id] : null;
            },
            remove: function (id) {
                delete this.benefits[id];
            }
        };
        return {
            new: function (service_plan_id) {
                return new BenefitCollection(service_plan_id);
            }
        };
    });
    clientManagerApp.service('benefitFactory', ['$http',function ($http) {
        var Benefit = function (args) {
            for (var i in args) {
                if (this.fields.indexOf(i) !== -1) {
                    this[i] = args[i];
                }
            }
            this.saved=false;
        };
        Benefit.prototype = {
            fields: ['id', 'name', 'icon', 'description'],
            save: function(){
                if(!this.saved){
                    console.log('saving',$http);
                    this.saved=true;
                }
            }

        };
        return {
            new: function (args) {
                return new Benefit(args);
            }
        }
    }]);

    clientManagerApp.directive('benefits', function () {
        return {
            restrict: "E",
            controller: ['$scope', 'Upload', 'benefitFactory', '$interval', 'benefitCollection', function ($scope, Upload, benefitFactory, $interval, benefitCollection) {
                function initForDashboard() {
                    var loadingInterval = $interval(function () {
                        if ($scope.client.service_plan.benefits.isBenefitCollection && $scope.client.service_plan.benefits.isInitialized) {
                            self.benefits = $scope.client.service_plan.benefits.benefits;

                            $interval.cancel(loadingInterval);
                        }
                    }, 20);
                    $scope.$on('$destroy', function () {
                        $interval.cancel(loadingInterval);
                    });
                }


                var self = this;
                this.new_benefits = [];
                $scope.client = $scope.$parent.client;
                this.batch_edit = $scope.benefits_batch;


                this.addBenefit = function () {
                    this.addMode = true;
                    this.new_benefits.push({});

                };
                this.cancelNewBenefit = function (index) {
                    this.addMode = false;
                    this.new_benefits.splice(index, 1);
                };

                this.saveNewBenefitByIndex = function (index) {
                    var new_benefit = this.new_benefits[index];
                    this.saveNewBenefit(new_benefit);
                };
                this.saveNewBenefit = function (benefit, callback) {

                    var api_url = '/api/client-manager/benefits';
                    benefit.service_plan_id = $scope.client.service_plan.id;
                    Upload.upload({
                            url: api_url,
                            data: benefit
                        }
                    ).then(function success(response) {
                            var result = response.data;
                            $scope.client.service_plan.benefits.add(benefitFactory.new(result));
                            self.addMode = false;
                            if (typeof callback === 'function') {
                                callback(response);
                            }
                        }, function error(response) {
                        }, function event(response) {
                        });

                };
                //@todo: when saving benefits, skip blank ones


                function initForClients() {
                    $scope.$on('newClientAdded', function (event, args, callback) {
                        var collection = benefitCollection.new(args.service_plan.id);
                        $scope.client = args;
                        var new_benefit_count = self.new_benefits.length;
                        var benefits_saved = 0;
                        for (var i = 0; i < new_benefit_count; i++) {
                            var benefit = self.new_benefits[i];
                            benefit.service_plan_id = args.service_plan.id;
                            self.saveNewBenefit(benefit, function (data) {
                                benefits_saved++;
                                collection.add(data.data);
                                if (benefits_saved == new_benefit_count) {
                                    self.benefits=[];
                                    if (typeof callback === 'function') {
                                        callback(collection);
                                    }
                                }
                            });
                        }
                    });
                }

                if (this.batch_edit !== true) {
                    return initForDashboard();
                }


                return initForClients();
            }],
            controllerAs: 'benefitsController',

            templateUrl: '/api/client-manager/templates/benefits'
        }
    });


}());