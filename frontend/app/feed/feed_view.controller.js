'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedViewController', FeedViewController);

    FeedViewController.$inject = ['$scope', 'FeedService'];

    function FeedViewController($scope, FeedService) {
        $scope.source = {};
        $scope.loading = true;

        FeedService.getAll()
            .then(function(resp) {
                console.log(resp.data)
                $scope.source = resp.data.item;
                $scope.loading = false;
            }, function() {
                $scope.loading = false;
            });
    }
})();
