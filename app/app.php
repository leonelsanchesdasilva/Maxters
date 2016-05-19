<?php
$router->get('/', 'Maxters\Controllers\Home::index');

$router->get('info/{str?}', function ($info = null) use ($router) {
	if ($info === null) {
		$data = sprintf('PHP version is %f', PHP_VERSION);
	} elseif ($info == 'router') {
		$data = sprintf('The router class name is "%s"', get_class($router));
	}

	return $data;
});
