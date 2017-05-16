'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedListController', FeedListController);

    FeedListController.$inject = ['$scope', '$routeParams', '$controller', 'FeedService'];

    function FeedListController($scope, $routeParams, $controller, FeedService) {
        angular.extend(this, $controller('BaseController', {$scope: $scope}));

        $scope.sources = [];
        $scope.loading = true;
        $scope.page = 1;

        FeedService.getAll({
            page: $routeParams.page
        })
            .then(function(resp) {
                $scope.page        = resp.data.page;
                $scope.total_pages = resp.data.total_pages;
                $scope.sources     = resp.data.items;

                $scope.loading = false;
            }, function() {
                $scope.loading = false;
            });
    }
})();
