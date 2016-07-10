<?php

use PHPLegends\Http\Response;
use PHPLegends\Http\RedirectResponse;
use PHPLegends\Http\JsonResponse;

$router->get('/', 'Maxters\Controllers\Home::index')->setName('home');

$router->group(['namespace' => 'Maxters\Controllers'], function ($router)
{
    $router->routable('UsersController');
});
