App.controller('FeedCtrl', ['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {
    var feedId = $scope.feedId = $routeParams.feedId;

    $http.get('/api/v1/feeds/' + feedId).success(function(data) {
        $scope.feed = data.Feed;
    });
}]);
