'use strict';

(function() {
    angular
        .module('app.routes', ['ngRoute', ])
        .config(config);

    config.$inject = ['$routeProvider', '$locationProvider'];

    function config ($routeProvider, $locationProvider) {
        $locationProvider
            .hashPrefix('');

        $routeProvider
            .when('/', {
                templateUrl: 'app/home/home.html',
                controller: 'HomeController'
            })
            .when('/login', {
                templateUrl: 'app/login/login.html',
                controller: 'LoginController'
            })
            .when('/sign-up', {
                templateUrl: 'app/signup/signup.html',
                controller: 'SignupController'
            })
            .when('/feed/list', {
                templateUrl: 'app/feed/views/feed_list.html',
                controller: 'FeedListController'
            })
            .when('/feed-source/list', {
                templateUrl: 'app/feed/views/sources_list.html',
                controller: 'FeedSourceListController'
            })
            .when('/feed-source/:type/:id', {
                templateUrl: 'app/feed/views/view_source.html',
                controller: 'FeedSourceViewController'
            })
            .when('/feed/:type/:id', {
                templateUrl: 'app/feed/views/view.html',
                controller: 'FeedViewController'
            })
            .when('/feed-source/add', {
                templateUrl: 'app/feed/views/add.html',
                controller: 'FeedSourceEditController'
            })
            .otherwise({
                redirectTo: '/'
            });
    }
})();
