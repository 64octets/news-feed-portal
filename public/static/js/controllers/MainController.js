App.controller('MainCtrl', ['$scope', 'dates', function ($scope, dates) {
    dates.success(function(data) {
        $scope.dates = data.Dates;
    });
}]);
