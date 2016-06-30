app.controller('infos', function ($scope, $http) {

    $http.get('/ajax/infos/').then(function (response) {
        $scope.infos = response.data;
    });
});
