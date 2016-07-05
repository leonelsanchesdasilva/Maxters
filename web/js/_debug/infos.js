app.controller('_debug.infos', function ($scope, $http) {

    $http.get('/_debug/ajax-infos/').then(function (response) {
        
        $scope.infos = response.data;
    });
});
