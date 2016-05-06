	<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app/');

define('WEB_PATH', ROOT_PATH . '/app/');

include_once ROOT_PATH . '/vendor/autoload.php';

$router = new \PHPLegends\Routes\Router;

call_user_func(function () use($router)
{
	include_once APP_PATH . '/app.php';
});

return $router;