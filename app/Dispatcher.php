<?php

namespace Maxters;

use Maxters\Container;
use PHPLegends\Routes\Router;
use PHPLegends\Http\Response;
use PHPLegends\Routes\Collection;
use PHPLegends\Http\JsonResponse;
use PHPLegends\Http\Request;
use PHPLegends\Routes\Dispatchable;
use PHPLegends\Http\Exceptions\HttpException;
use PHPLegends\Http\Exceptions\NotFoundException;

/**
 * Dispatcher for Maxters Framework application
 * This dispatcher is costume of this framework and implement Dispatchable for PHPLegends\Route packages
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 * 
 * */
class Dispatcher implements Dispatchable
{
	
	/**
	 * @var \Maxters\Container
	 * */
	protected $app;

	public function __construct(Container $app)
	{
		$this->app = $app;
	}

	public function dispatch(Router $router)
	{
		$request = $this->app['request'];

		$uri = $request->getUri()->getPath();

		$routes = $this->filterRoutesByRequest($request, $router->getCollection());

		$method = $request->getMethod();

		$route = $routes->findByVerb($method);

		if ($route === null) {

			$message = sprintf(
				'Method "%s" is not allowed for "%s" route', $method, $uri
			);

			throw $this->getHttpException($message, 405);
		}

		$resultFilter = $router->getFilters()
								->processRouteFilters($route, $this->app);

		if ($resultFilter !== null) {

			return $this->processFilterResult($resultFilter);
		}

		$action = $this->resolveRouteAction($route);

		$response = call_user_func_array($action, $route->match($uri));

		return $this->processRouteResponse($response);

	}

	/**
	 * 
	 * 
	 * @param string $class
	 * @param string $method
	 * */
	protected function resolverControllerInstance($class, $method)
	{
		$controller = new $class;

		$controller->setApp($this->app);

		return [$controller, $method];
	}

	/**
	 * 
	 * 
	 * @param string $resultFilter
	 * @return 
	 * */
	protected function processFilterResult($resultFilter)
	{
		
		if (is_string($resultFilter))
		{
			$resultFilter = $this->createResponse($resultFilter)->send();
		}

		// if ($resultFilter instanceof \PHPLegends\Http\Response)
		// {
				//throw new 		
		// }

		$resultFilter->setHeaders($this->app['headers']);

		$resultFilter->send();
	}

	protected function processRouteResponse($response)
	{

		if ($this->shouldBeResponse($response)) {

			$response = $this->createResponse($response, 200, [
				'Content-Type' => 'text/html; charset=utf8;'
			]);

		} elseif ($this->shouldBeJsonResponse($response)) {

			$response = $this->createJsonResponse($response, 200);

		} elseif (! $response instanceof Response) {

			throw new \RunTimeException(
				sprintf(
					'Unprocessable response of type "%s"',
					is_object($response) ? get_class($response) : gettype($response)
				)
			);
		}

		$response->setHeaders($this->app['headers']);
		
		$response->send();
	}

	protected function shouldBeJsonResponse($candidate)
	{
		return is_array($candidate) 
				|| $candidate instanceof \JsonSerializable 
				|| $candidate instanceof \ArrayObject 
				|| $candidate instanceof \stdClass;
	}

	/**
	 * Detect if response should be PHPLegends\Http\Response instance
	 * 
	 * @param mixed $candidate
	 * @return boolean
	 * */
	protected function shouldBeResponse($candidate)
	{
		return is_string($candidate) || $candidate instanceof \PHPLegends\View\View;
	}

	protected function filterRoutesByRequest(Request $request, Collection $routes)
	{

		$uri = $request->getUri()->getPath();

		$routes = $routes->filterByUri($uri);

		if ($routes->isEmpty()) {

			throw new NotFoundException("Route '{$uri}' not found");
		}

		return $routes;
	}

	protected function resolveRouteAction($route)
	{
		$action = $route->getAction();

		if (is_array($action)) {
			
			$action = $this->resolverControllerInstance($action[0], $action[1]);

		} else {

			$action = $action->bindTo($this->app);
		}

		return $action;
	}

	protected function getHttpException($message, $statusCode = 500)
	{		
		return new HttpException($message, $statusCode);
	}

	protected function createResponse($message, $code = 200)
	{
		return new Response($message, $code);
	}

	protected function createJsonResponse($data)
	{
		return new JsonResponse($data, 200, $this->app['headers']);
	}
	
}