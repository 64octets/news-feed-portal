var App = angular.module('App', ['ngRoute']);

App.config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/', {
      controller: 'MainCtrl',
      templateUrl: '/static/template/home.html'
    })
    .when('/publications/:date', {
        controller: 'PublicationCtrl',
        templateUrl: '/static/template/publications.html'
    })
    .when('/feeds/:feedId', {
        controller: 'FeedCtrl',
        templateUrl: '/static/template/feed-detail.html'
    })
    .otherwise({
      redirectTo: '/'
    });
}]);

App.filter('trusted', ['$sce', function ($sce) {
    return function(url) {
        return $sce.trustAsResourceUrl(url);
    };
}]);
