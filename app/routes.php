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

$router->get('/redirect', function () {

	return $this->response('/', 301);
});