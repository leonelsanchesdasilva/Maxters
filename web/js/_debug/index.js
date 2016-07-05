app.controller('_debug.index', function ($scope, $http)
{
    $http.get('/_debug/ajax-routes').then(function (response) {

        $scope.routes = response.data;
    })
})