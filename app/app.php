<?php

$router->addFilter('check.query.error', function ($route, $app)
{
	// Adicione "error" na query string da url para testar

	if (isset($app['request']->getQueryParams()['error']))
	{
		return new PHPLegends\Http\JsonResponse(['Invalid parameter'], 400);
	}
});

$router->get('/', 'Maxters\Controllers\Home::index')->setFilters(['check.query.error']);