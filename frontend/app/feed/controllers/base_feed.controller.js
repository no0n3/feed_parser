'use strict';

(function() {
    angular
        .module('app')
        .controller('BaseFeedController', BaseFeedController);

    BaseFeedController.$inject = ['$scope', '$controller', 'FeedSourceService'];

    function BaseFeedController($scope, $controller, FeedSourceService) {
        angular.extend(this, $controller('BaseController', {$scope: $scope}));

        $scope.deleteFeedSource = function(data) {
            console.log('in base feed source item')
            return FeedSourceService.delete(data);
        };
    }
})();
