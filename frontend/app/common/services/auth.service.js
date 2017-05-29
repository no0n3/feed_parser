'use strict';

(function() {
    angular
        .module('app')
        .factory('authService', authService);

    authService.$inject = ['$http', 'serverDomain'];

    function authService($http, serverDomain) {
        return {
            /**
             * Gets the data (id, username, email) of the currently logged user.
             * @param {type} data
             * @returns {undefined}
             */
            getUserData : function(data) {
                return $http.get(serverDomain + 'main/user');
            },
            login : function(data) {
                return $http.post(serverDomain + 'main/login', data);
            },
            logout : function(data) {
                return $http.post(serverDomain + 'main/logout', data);
            },
            signup : function(data) {
                return $http.post(serverDomain + 'main/signup', data);
            },
            getLoggedUserData : function() {
                return $http.get(serverDomain + 'main/user');
            }
        };
    }
})();
