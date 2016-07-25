<?php

namespace Maxters;

use PHPLegends\Http\Request;
use PHPLegends\Routes\Route;
use PHPLegends\Http\Response;
use PHPLegends\Routes\Router;
use Maxters\Providers\Container;
use PHPLegends\Http\JsonResponse;
use Maxters\Controllers\Controller;
use PHPLegends\Routes\Dispatchable;
use PHPLegends\Http\Exceptions\HttpException;
use PHPLegends\Http\ResponseHeaderCollection;
use PHPLegends\Routes\Traits\DispatcherTrait;
use PHPLegends\Http\Exceptions\NotFoundException;
use PHPLegends\Http\Exceptions\MethodNotAllowedException;
use PHPLegends\Routes\Exceptions\NotFoundException as RouteNotFoundException;

/**
 * Dispatcher for Maxters Framework application
 * This dispatcher is costume of this framework and implement Dispatchable for PHPLegends\Route packages
 *
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 *
 * */
class Dispatcher implements Dispatchable
{

    use DispatcherTrait;

    /**
     * @var \Maxters\Container
     * */
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * 
     * @param \PHPLegends\Routes\Router $router
     * @return \PHPLegends\Http\Response
     * */
    public function dispatch(Router $router)
    {
        $request = $this->app['request'];

        $this->app['current_route'] = $route = $this->findRouteByRequest($router, $request);

        if (($filter = $this->callRouteFilters($router, $route)) !== null) {

            return $this->resolveResponseValue($filter);
        }

        $response = $this->callRouteAction($route);

        return $this->resolveResponseValue($response);
    }

    /**
     * 
     * @param \PHPLegends\Routes\Router $router
     * @param \PHPLegends\Routes\Route $route
     * */
    protected function callRouteFilters(Router $router, Route $route)
    {
        foreach ($router->getFilters()->filterByRoute($route) as $filter) {

            $result = call_user_func($filter->getCallback(), $this->app);

            if ($result !== null) return $result;
        }   
    }

    /**
     * Overwrites buildRouteAction of Trait
     * 
     * @param PHPLegends\Routes\Route $route
     * @return callable
     * */
    protected function buildRouteAction(Route $route)
    {
        $action = $route->getAction();

        if ($action instanceof \Closure) {

            $controller = (new Controller())->setApp($this->app);

            return $action->bindTo($controller, get_class($controller));
        }

        list ($class, $method) = $action;

        $class = new $class;

        $class->setApp($this->app);

        return [$class, $method];
    }

    /**
     * 
     * @param \PHPLegends\Routes\Route $router
     * @param \PHPLegends\Http\Request $request
     * @return \PHPLegends\Routes\Route
     * @throws PHPLegends\Http\Exceptions\MethodNotAllowedException
     * */
    protected function findRouteByRequest(Router $router, Request $request)
    {
        try {

            return $router->findRoute(
                $request->getUri()->getPath(),
                $request->getMethod()
            );

        } catch (RouteNotFoundException $e) {

            throw new NotFoundException('Route not found');

        } catch (InvalidVerbException $e) {

            throw MethodNotAllowedException::createFromRequest($request);
        }
    }

    /**
     * 
     * @param mixed $response
     * @param int $defaultCode
     * @return \PHPLegends\Http\Response
     * */
    protected function resolveResponseValue($response, $defaultCode = 200)
    {
        if ($this->shouldBeResponse($response)) {

            $response = new Response($response, $defaultCode);

        } elseif ($this->shouldBeJsonResponse($response)) {

            $response = new JsonResponse($response, $defaultCode);

        } elseif (! $response instanceof Response) {

            $message = sprintf(
                'Unprocessable response of type "%s"',
                is_object($response) ? get_class($response) : gettype($response)
            );

            throw new \RunTimeException($message);
        }

        $this->mergeCookiesAndHeaders($response, $this->app['headers']);

        $response->withSession($this->app['session']);

        $response->send(true);

        return $response;
    }

    /**
     * 
     * @param \PHPLegends\Http\Response $response
     * @param \PHPLegends\Http\ResponseHeaderCollection $headers
     * @return void
     * */
    protected function mergeCookiesAndHeaders(Response $response, ResponseHeaderCollection $headers)
    {
        $responseHeaders = $response->getHeaders();

        $responseHeaders->isEmpty() || $headers->addAll($responseHeaders);

        $response->setHeaders($headers);

        $headers->getCookies()->addAll($responseHeaders->getCookies());
    }
    
    /**
     * 
     * @param mixed $candidate
     * @return boolean
     * */
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
}

