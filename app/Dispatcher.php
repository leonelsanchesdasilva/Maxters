<?php

namespace Maxters;

use PHPLegends\Routes\Dispatchable;
use PHPLegends\Routes\Router;
use PHPLegends\Http\ServerRequest;

class Dispatcher implements Dispatchable
{
	protected $app;

	public function __construct(\Maxters\Container $app)
	{
		$this->app = $app;
	}

	public function dispatch(Router $router)
	{
		$request = $this->app['request'];

		$uri = $request->getUri()->getPath();

		$method = $request->getMethod();

		// Filter retorna um ou mais candidatos

		$routes = $router->getCollection()->filterByUri($uri);

		if ($routes->isEmpty()) {

			// @TODO criar a classe HttpException no PHPLegends\Http

			throw new \RunTimeException("Route '{$uri}' not found");
		}

		// "Find" retorna um ou NULL

		$route = $routes->findByVerb($method);

		if ($route === null) {

			// @TODO lancar um http Exception com "405", método não aceito

			throw new \RuntTimeException(sprintf(
				'Method "%s" is not allowed for "%s" route',
				$method,
				$uri
			));
		}

		$resultFilter = $router->getFilters()
								->processRouteFilters($route, $this->app);

		if ($resultFilter !== null) {

			return $this->processFilterResult($resultFilter);
		}

		$routeArgs = $route->match($uri);

		$action = $route->getAction();

		if (is_array($action)) {
			
			$action = $this->resolverControllerInstance($action[0], $action[1]);

		} else {

			$action->bindTo($this->app);
		}

		$response = call_user_func_array(
			$action, $routeArgs
		);

		return $this->processRouteResponse($response);

	}

	protected function resolverControllerInstance($class, $method)
	{
		$controller = new $class;

		$controller->setApp($this->app);

		return [$controller, $method];
	}

	protected function processFilterResult($resultFilter)
	{
		if ($resultFilter instanceof \Exception)
		{
			throw $resultFilter;
		}

		if ($resultFilter instanceof \PHPLegends\Http\Response)
		{
			return $resultFilter->send();
		}

		if (is_string($resultFilter))
		{
			throw new \Exception($resultFilter);
		}

		throw new \Exception('Unprocessable filter value');
	}

	protected function processRouteResponse($response)
	{

		if ($this->shouldBeResponse($response)) {

			$response = new \PHPLegends\Http\Response($response, 200, [
				'Content-Type' => 'text/html; charset=utf8;'
			]);

			$response;

		} elseif ($this->shouldBeJsonResponse($response)) {

			$response = new \PHPLegends\Http\JsonResponse($response, 200, JSON_PRETTY_PRINT);

		} elseif (! $response instanceof \PHPLegends\Http\Response) {

			throw new \RunTimeException(
				sprintf(
					'Unprocessable response of type "%s"',
					is_object($response) ? get_class($response) : gettype($response)
				)
			);
		}

		$response->send();
	}

	protected function shouldBeJsonResponse($candidate)
	{
		return is_array($candidate) 
				|| $candidate instanceof \JsonSerializable 
				|| $candidate instanceof \ArrayObject 
				|| $candidate instanceof \stdClass;
	}

	protected function shouldBeResponse($candidate)
	{
		return is_scalar($candidate) || $candidate instanceof \PHPLegends\View\View;
	}

	
}