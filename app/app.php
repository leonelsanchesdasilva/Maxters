<?php

$router->addFilter('check.query.error', function ($route, $app)
{
	// Adicione "error" na query string da url para testar

	if (isset($app['request']->getQueryParams()['error'])) {
		return new PHPLegends\Http\JsonResponse(['Invalid parameter'], 400);
	}
});


$router->get('/', 'Maxters\Controllers\Home::index')->setFilters(['check.query.error']);

$router->get('/json', 'Maxters\Controllers\Home::jsonExample');

// @TODO Guilherme, dá uma olhada nessa rota
// Veja que consegui injetar o "this" dentro da closure

$router->get('/closure', function ()
{
	
});

$router->get('/redirect', function () {

	return $this['response.redirect']('/', 301, ['X-Redirected' => 1]);
});