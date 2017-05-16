'use strict';

(function() {
    angular
        .module('app')
        .controller('FeedSourceEditController', FeedSourceEditController);

    FeedSourceEditController.$inject = ['$scope', '$location', 'FeedSourceService'];

    function FeedSourceEditController($scope, $location, FeedSourceService) {
        $scope.types = ['type_rss', 'type_twitter'];

        reset();

        function reset() {
            $scope.source = {};
            $scope.loading = false;
            $scope.added = false;

            $scope.source.type = $scope.types[0];
        }

        $scope.create = function() {
            FeedSourceService.add($scope.source)
                .then(function(resp) {
                    console.log(resp.data)
                    $scope.loading = false;
                    $scope.added = true;
                }, function() {
                    $scope.loading = false;
                });
        };

        $scope.addAnother = function() {
            reset();
        };
        $scope.viewAll = function() {
            $location.path('/feed-source/list');
        };
    }
})();
