app.controller('users.index', function ($scope, $http) {

    (function _ajax() {

        _ajax.page = typeof(_ajax.page) === 'undefined' ? 1 : ++_ajax.page;

        $http.get('/users/ajax-list/' + _ajax.page).then(function (response) {

            if (! response.data.length) return;

            $scope.users = response.data;

            setTimeout(_ajax, 1000);

        });

    })();
});

app.controller('users.create', function ($scope, $http) {

    $scope.update = function(user) {

        $http.post(
            '/users/ajax-create',
            user,
            {'Content-Type' : 'application/x-www-form-urlencoded'}
        ).then(function (response) {

            console.log(response.data)
        });
    };
});


