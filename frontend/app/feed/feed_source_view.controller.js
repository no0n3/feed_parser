'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedSourceViewController', FeedSourceViewController);

    FeedSourceViewController.$inject = ['$scope', '$routeParams', '$location', 'FeedSourceService'];

    function FeedSourceViewController($scope, $routeParams, $location, FeedSourceService) {
        console.log("VIEW FSx x")
        $scope.source = {};
        $scope.loading = true;

        FeedSourceService.get($routeParams)
            .then(function(resp) {
                console.log(resp.data)
                $scope.source = resp.data.item;
                $scope.loading = false;
            }, function() {
                $scope.loading = false;
            });
    }
})();
