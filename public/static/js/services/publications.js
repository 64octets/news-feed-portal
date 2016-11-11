App.factory('publications', ['$routeParams', '$http', '$location', function($routeParams, $http, $location) {
    var path = $routeParams.date;
    // var path = $location.path().split('/').reverse()[0];
    return $http.get('/api/v1/feeds/?Search=' + path).success(function(data) {
        return data;
    }).error(function(err) {
        return err;
    });
}]);
