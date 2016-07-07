<?php

use PHPLegends\Http\Response;
use PHPLegends\Http\RedirectResponse;
use PHPLegends\Http\JsonResponse;

$router->get('/', 'Maxters\Controllers\Home::index')->setName('home');


$router->get('/cookie', function () {

    $this->app['cookies']->set('name', 'Wallace');

    $this->app['headers']->merge(['X-Men' => 'Evolution']);

    return ['My name is json'];

})->setName('cookies');

$router->post('upload', function () {

    foreach ($this->request()->getUploadedFiles()->get('files') as $file) {

        $file->moveToDirectory(WEB_PATH . '/uploads/');
    }

    return new RedirectResponse('/upload');
});

$router->get('upload', function () {

    return $this->render('home/upload', []);

})->setName('upload');


$router->get('redirect', function () {

    return new RedirectResponse('/users');

})->setName('redirect_to.users');


$router->group(['namespace' => 'Maxters\Controllers'], function ($router)
{
    $router->routable('UsersController');
});
