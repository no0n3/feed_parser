'use strict';

(function () {
    angular
        .module('app', ['ngRoute', 'app.routes', 'app.templates'])
        .run(run);

    run.$inject = ['$rootScope', '$location', '$route', 'siteDomain', 'authService'];

    function run($rootScope, $location, $route, siteDomain, authService) {
        $rootScope.siteDomain = siteDomain;

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            getLoggedUserData(function(resp) {
                if (false === resp.logged && isRestrictedPath()) {
                    $location.path('/login');
                }
            });
        });

        var unrestricted = [
            '/login',
            '/sign-up'
        ];

        $rootScope.$on('$routeChangeStart', function(event) {
            console.log('args:')
            console.log(arguments)
            console.log(event)
        });

        function getLoggedUserData(callback) {
            authService.getUserData()
                .then(function(resp) {
                    if ('function' === typeof callback) {
                        callback(resp.data);
                    }
                });
        }

        function isRestrictedPath() {
            var result = -1 === unrestricted.indexOf($location.path());

            return result;
        }
    }
})();
