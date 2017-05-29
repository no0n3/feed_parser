'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedSourceListController', FeedSourceListController);

    FeedSourceListController.$inject = ['$scope', 'siteDomain', '$routeParams', '$controller', 'FeedSourceService'];

    function FeedSourceListController($scope, siteDomain, $routeParams, $controller, FeedSourceService) {
        angular.extend(this, $controller('BaseFeedController', {$scope: $scope}));

        $scope.sources = [];
        $scope.loading = true;
        $scope.page = 1;
        $scope.siteDomain = siteDomain;

        $scope.deleteFeedSourceItem = function(data) {
            console.log('---43')
            console.log(data)
            $scope.deleteFeedSource(data)
                .then(function(resp) {
                    console.log('---1')
                }, function() {
                    console.log('---2')
                });
        };

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
