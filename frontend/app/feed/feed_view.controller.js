'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedViewController', FeedViewController);

    FeedViewController.$inject = ['$scope', '$routeParams', 'FeedService'];

    function FeedViewController($scope, $routeParams, FeedService) {
        $scope.source = {};
        $scope.loading = true;

        FeedService.get($routeParams)
            .then(function(resp) {
                console.log(resp.data)
                $scope.source = resp.data.item;
                $scope.loading = false;
            }, function() {
                $scope.loading = false;
            });
    }
})();
