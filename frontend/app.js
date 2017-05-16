'use strict';

(function () {
    angular
        .module('app', ['ngRoute', 'app.routes', 'app.templates'])
        .run(run);

    run.$inject = ['$rootScope', '$location', '$route', 'siteDomain'];

    function run($rootScope, $location, $route, siteDomain) {
        $rootScope.siteDomain = siteDomain;

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            console.log('nx ->', $location.path())

            if (-1 !== restricted.indexOf($location.path())) {
                console.log('RESTRICTED URL')
            }
        });

        var restricted = [
            
        ];

        $rootScope.$on('$routeChangeStart', function(event) {
            console.log('args:')
            console.log(arguments)
            console.log(event)
        });
    }
})();
