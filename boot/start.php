<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app/');

define('WEB_PATH', ROOT_PATH . '/app/');

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Container;

$app->singleton('app', $app);

$app->singleton('router', $router = new \PHPLegends\Routes\Router);

$app['view'] = function ($name, $data) {

	$path = APP_PATH . '/Views/';

	return new \PHPLegends\View\View($name, $data, $path, 'phtml');
};

$app->singleton('request', PHPLegends\Http\ServerRequest::createFromGlobals());

call_user_func(function () use ($app, $router)
{
	include_once APP_PATH . '/app.php';
});

return $app;