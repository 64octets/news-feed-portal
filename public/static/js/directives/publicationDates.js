App.directive('publicationDates', function() {
    return {
        restrict: 'E',
        scope: {
            info: '='
        },
        templateUrl: '/static/js/directives/publicationDates.html'
    };
});
