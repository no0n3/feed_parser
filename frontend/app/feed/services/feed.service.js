'use strict';

(function() {
    angular
        .module('app')
        .factory('FeedService', FeedService);

    FeedService.$inject = ['$http', 'serverDomain'];

    function FeedService($http, serverDomain) {
        return {
            getAll: function(data) {
                return $http.get(
                    serverDomain + 'feed/get-all' + (data.page ? ('?page=' + data.page) : ''),
                    data
                );
            },
            get: function(data) {
                return $http.get(
                    serverDomain + 'feed/get' + (data.id ? ('?id=' + data.id) : ''),
                    data
                );
            }
        };
    }
})();
