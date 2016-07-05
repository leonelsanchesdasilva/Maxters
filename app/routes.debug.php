<?php

$router->group(['namespace' => 'Maxters\Controllers'], function ($router)
{
    $router->routable('Debug\DebugController', '_debug');
    $router->routable('UsersController');
});