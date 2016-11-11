App.controller('PublicationCtrl', ['$scope', '$routeParams', '$http', function ($scope, $routeParams, $http) {
    var path = $scope.date = $routeParams.date;

    $http.get('/api/v1/feeds/?Search=' + path).success(function(data) {
        $scope.publications = data.Feeds
    });
}]);
