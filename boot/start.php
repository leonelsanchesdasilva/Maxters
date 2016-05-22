<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app/');

define('WEB_PATH', ROOT_PATH . '/app/');

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Container;

// Define container Classes

$app['debug'] = true;

$app->singleton('router', new \PHPLegends\Routes\Router);

$app['view'] = function ($name, $data) {

	$path = APP_PATH . '/Views/';

	return new \PHPLegends\View\View($name, $data, $path, 'phtml');
};

$app->singleton('request', PHPLegends\Http\ServerRequest::createFromGlobals());

$app['response'] = function ($message, $code, array $headers = [])
{
	return new PHPLegends\Http\Response($message, $code, $headers);
};

$app['response.view'] = function ($name, array $data = [], $code = 200, array $headers = []) use($app)
{
	return $app['response']($app['view']($name, $data)->render(), $code, $headers);
};

$app['response.json'] = function ($data, $code = 200, array $headers = [])
{
	return new PHPLegends\Http\JsonResponse($data, $code, 0, $headers);
};

$app['response.redirect'] = function ($to, $code = 200, array $headers = [])
{
	return new PHPLegends\Http\RedirectResponse($to, $code, $headers);
};

call_user_func(function () use ($app) {

	$router = $app['router'];

	include_once APP_PATH . '/app.php';
});

return $app;