<?php

use PHPLegends\Http\Response;
use PHPLegends\Http\RedirectResponse;
use PHPLegends\Http\JsonResponse;

$router->get('/', 'Maxters\Controllers\Home::index')
        ->setName('home');

$router->group(['namespace' => 'Maxters\Controllers'], function ($router)
{
    $router->routable('UsersController');
});

$router->addFilter('age', function ($app) {

    if (filter_input(INPUT_GET, 'age') < 18) {

        $app['cookies']['nome'] = 'Wallace de Souza';

        return new Response('Você é de menor', 401);
    }
});
