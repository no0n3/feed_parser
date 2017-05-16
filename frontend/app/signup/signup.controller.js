'use strict';

(function() {
    angular
        .module('app')
        .controller('SignupController', SignupController);

    SignupController.$inject = ['$scope', 'authService', '$location'];

    function SignupController($scope, authService, $location) {
        $scope.loading = false;
        $scope.user = {};

        $scope.signup = function(form) {
            if (form.email.$valid && form.name.$valid && form.password.$valid) {
                $scope.loading = true;

                authService
                    .signup({
                        email : $scope.user.email,
                        name : $scope.user.name,
                        password : $scope.user.password
                    })
                    .then(function(resp) {
                        if (resp.data.registered) {
                            $location.path('/login');
                        } else {
                            $scope.loading = false;
                        }
                    }, function() {
                        $scope.loading = false;
                    });
            }
        };

        $scope.goToLogin = function() {
            $location.path('/login');
        };
    }
})();
