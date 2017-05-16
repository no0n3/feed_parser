'use strict';

(function() {
    angular
        .module('app')
        .factory('FeedSourceService', FeedSourceService);

    FeedSourceService.$inject = ['$http', 'serverDomain'];

    function FeedSourceService($http, serverDomain) {
        return {
            getAll: function(data) {
                return $http.get(
                    serverDomain + 'feed-source/get-all' + (data.page ? ('?page=' + data.page) : ''),
                    data
                );
            },
            get: function(data) {
                return $http.get(
                    serverDomain + 'feed-source/get' + (data.id ? ('?id=' + data.id) : ''),
                    data
                );
            },
            add: function(data) {
                return $http.post(
                    serverDomain + 'feed-source/add',
                    data
                );
            }
        };
    }
})();
