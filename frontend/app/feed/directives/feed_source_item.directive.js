'use strict';

(function() {
    angular
        .module('app')
        .directive('feedSourceItem', ['FeedSourceService', function(FeedSourceService) {
            return {
                scope: {
                    source: '=item'
                },
                templateUrl: 'app/feed/views/feed_source_item.html',
                link: function($scope) {
                    console.log('in l')
                    $scope.deleteFeedSourceItem = function(data) {
                        console.log('---43')
                        console.log(data)
                        FeedSourceService.deleteItem(data)
                            .then(function(resp) {
                                $scope.source.deleted = true;
                                console.log('---1')
                            }, function() {
                                console.log('---2')
                            });
                    };
                }
            };
        }]);

})();
