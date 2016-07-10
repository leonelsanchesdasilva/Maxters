<?php

use PHPLegends\Http\RedirectResponse;

$router->group(['namespace' => 'Maxters\Controllers'], function ($router)
{
    $router->routable('Debug\DebugController', '_debug');
});


// Cookies test


$router->get('/cookie', function () {

    $this->app['cookies']->set('name', 'Wallace');

    $this->app['headers']->merge(['X-Men' => 'Evolution']);

    return ['My name is json'];

})->setName('cookies');


// Upload test

$router->post('upload', function () {

    foreach ($this->request()->getUploadedFiles()->get('files') as $file) {

        $file->moveToDirectory(WEB_PATH . '/uploads/');
    }

    return new RedirectResponse('/upload');
});

$router->get('upload', function () {

    return $this->render('home/upload', []);

})->setName('upload');


// Redirector tests

$router->get('redirect_users', function () {

    return new RedirectResponse(
        $this->app['url']->action('Maxters\Controllers\UsersController::actionIndexGet')
    );

})->setName('redirect_to.users');

$router->get('redirect', function () {

    return new RedirectResponse(
        $this->app['url']->route('home')
    );

})->setName('redirect_to.home');