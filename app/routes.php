<?php

use PHPLegends\Http\Response;
use PHPLegends\Http\RedirectResponse;
use PHPLegends\Http\JsonResponse;

$router->get('/', 'Maxters\Controllers\Home::index');

$router->get('/json-example', 'Maxters\Controllers\Home::jsonExample');

/**
 *
 * @link http://localhost:8000/test-exception/BadMethodCall
 * @link http://localhost:8000/test-exception/Length
 * @link http://localhost:8000/test-exception/Domain
 * 
 * */

$router->get('/test-exception/{str}', function ($exception)
{
	$class = $exception . 'Exception';

    throw new $class;
});

$router->get('infos', function ()
{
    return $this['view']->create('infos', ['app' => $this]);
});

$router->get('/cookie', function ()
{
    $this['cookies']->set('name', 'Wallace');

    $this['headers']->merge(['X-Men' => 'Evolution']);

    return ['My name is json'];

})->setName('cookies');

$router->post('upload', function ()
{
    foreach ($this['request']->getUploadedFiles()->get('files') as $file) {

        $file->moveToDirectory(WEB_PATH . '/uploads/');
    }

    return new RedirectResponse('/upload');
});

$router->get('upload', function ()
{

    return $this['view']->create('home/upload', []);
});


$router->get('routes', function () use($router)
{
    foreach ($router->getCollection() as $route)
    {
        $response[$route->getName() ?: $route->getPattern()] = $route->getPattern();
    }

    return $response;
});