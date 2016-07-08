(function () {
    "use strict";
    var clientManagerApp = angular.module('module-clients', ['module-servicePlan']);
    clientManagerApp.service('clientFactory', function (servicePlanFactory, $interval) {
        var Client = function (id, name,callback) {
            this.id = id;
            this.name = name;
            this.dataLoaded = false;
            this.callback = callback;
            this.init();
        };

        Client.prototype = {
            init: function () {
                this.service_plan = (servicePlanFactory.new(this.id,this.callback));
                var self = this;
                var initInterval = $interval(function () {

                    if (self.hasOwnProperty('service_plan')
                        && self.service_plan.hasOwnProperty('benefits')
                        && self.service_plan.hasOwnProperty('service_history')
                        && self.service_plan.benefits.hasOwnProperty('benefits')
                    ) {
                        self.dataLoaded = true;
                        $interval.cancel(initInterval);
                    }
                }, 20);


            }
        };

        return {
            new: function (id, name,callback) {
                return new Client(id, name,callback);
            }
        };
    });
    clientManagerApp.service('clientCollection', ['clientFactory', '$http', function (clientFactory, $http) {
        var ClientCollection = function () {
            this.clients = {};
        };
        ClientCollection.prototype = {
            initialize: function (callback) {
                var self = this;

                function getClientData() {
                    var client_api_url = '/api/client-manager/clients';
                    $http.get(client_api_url).then(function (response) {
                        var clients = response.data;
                        for (var i = 0; i < clients.length; i++) {
                            var client = clients[i];
                            self.add(( clientFactory.new(client.id, client.name)));
                        }
                    });
                }

                getClientData();
                if (typeof callback == 'function') {
                    callback();
                }
            },
            add: function (Client, callback) {
                this.clients[Client.id] = Client;

                if (typeof callback == 'function') {
                    callback();
                }
            },
            find: function (id) {
                return (this.clients.hasOwnProperty(id)) ? this.clients[id] : null;
            }


        };

        return (new ClientCollection());
    }]);

}());