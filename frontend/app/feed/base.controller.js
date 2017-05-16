'use strict';

(function() {
    angular
        .module('app')
        .controller('BaseController', BaseController);

    BaseController.$inject = ['$scope', '$location'];

    function BaseController($scope, $location) {
        $scope.page = null;
        $scope.headerUrl = 'app/header/views/main.html';

        $scope.prev = function() {
            if (1 < $scope.page) {
                $location.search('page', $scope.page - 1);
            }
        };
        $scope.next = function() {
            if ($scope.page < $scope.total_pages) {
                $location.search('page', +$scope.page + 1);
            }
        };
        $scope.first = function() {
            if (1 != $scope.page) {
                $location.search('page', 1);
            }
        };
        $scope.last = function() {
            if ($scope.total_pages != $scope.page) {
                $location.search('page', $scope.total_pages);
            }
        };
    }
})();
