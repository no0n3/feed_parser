'use strict';

(function() {
    angular
        .module('app')
        .directive('feedItem', function() {
            return {
                scope: {
                    source: '=item'
                },
                templateUrl: 'app/feed/views/feed_item.html'
            };
        });

})();
