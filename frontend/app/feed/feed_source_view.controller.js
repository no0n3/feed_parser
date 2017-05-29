'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedSourceViewController', FeedSourceViewController);

    FeedSourceViewController.$inject = ['$scope', '$routeParams', '$controller', 'FeedSourceService'];

    function FeedSourceViewController($scope, $routeParams, $controller, FeedSourceService) {
        angular.extend(this, $controller('BaseFeedController', {$scope: $scope}));

        console.log("VIEW FSx x")
        $scope.source = {};
        $scope.loading = true;

        FeedSourceService.get($routeParams)
            .then(function(resp) {
                console.log(resp.data)
                $scope.source = resp.data.item;
                $scope.sources = [resp.data.item];
                console.log('----')
                console.log($scope.source)
                $scope.loading = false;
            }, function() {
                $scope.loading = false;
            });
    }
})();
