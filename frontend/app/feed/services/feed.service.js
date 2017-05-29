'use strict';

(function() {
    angular
        .module('app')
        .factory('FeedService', FeedService);

    FeedService.$inject = ['$http', 'serverDomain'];

    function f(a) {
        var r = [];

        for (var i in a) {
            r.push(i + '=' + a[i]);
        }

        return r.join('&');
    }

    function FeedService($http, serverDomain) {
        return {
            getAll: function(data) {
                return $http.get(
                    serverDomain + 'feed/get-all?' + f(data),
                    data
                );
            },
            get: function(data) {
                return $http.get(
                    serverDomain + 'feed/get?' + f(data),
                    data
                );
            }
        };
    }
})();
