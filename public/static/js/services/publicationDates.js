App.factory('dates', ['$http', function($http) {
    return $http.get('/api/v1/feeds/publication_dates').success(function(data) {
        return data;
    }).error(function(err) {
        return err;
    });
}]);
