App.directive('publications', function() {
    return {
        restrict: 'E',
        scope: {
            info: '='
        },
        templateUrl: '/static/js/directives/publications.html'
    };
});
