'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedSourceListController', FeedSourceListController);

    FeedSourceListController.$inject = ['$scope', 'siteDomain', '$routeParams', '$controller', 'FeedSourceService'];

    function FeedSourceListController($scope, siteDomain, $routeParams, $controller, FeedSourceService) {
        angular.extend(this, $controller('BaseController', {$scope: $scope}));

        $scope.sources = [];
        $scope.loading = true;
        $scope.page = 1;
        $scope.siteDomain = siteDomain;

        FeedSourceService.getAll({
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
