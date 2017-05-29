'use strict';

(function() {
    angular
        .module('app')
        .factory('FeedSourceService', FeedSourceService);

    FeedSourceService.$inject = ['$http', 'serverDomain'];

    function f(a) {
        var r = [];

        for (var i in a) {
            r.push(i + '=' + a[i]);
        }

        return r.join('&');
    }

    function FeedSourceService($http, serverDomain) {
        return {
            getAll: function(data) {
                return $http.get(
                    serverDomain + 'feed-source/get-all?' + f(data),
                    data
                );
            },
            get: function(data) {
                return $http.get(
                    serverDomain + 'feed-source/get?' + f(data),
                    data
                );
            },
            add: function(data) {
                return $http.post(
                    serverDomain + 'feed-source/add',
                    data
                );
            },
            deleteItem: function(data) {
                return $http.post(
                    serverDomain + 'feed-source/delete',
                    data
                );
            }
        };
    }
})();
