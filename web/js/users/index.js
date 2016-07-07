app.controller('users.index', function ($scope, $http) {

    (function _ajax() {

        _ajax.page = typeof(_ajax.page) === 'undefined' ? 0 : ++_ajax.page;

        $http.get('/users/ajax-list/' + _ajax.page).then(function (response) {

            if (! response.data.length) return;

            $scope.users = response.data;

            setTimeout(_ajax, 1000);

        });

    })();

    $scope.create = function(user) {

        $http.post(
            '/users/ajax-create',
            user
        ).then(function (response) {
            $scope.users.push(response.data);
        });
    };
});


