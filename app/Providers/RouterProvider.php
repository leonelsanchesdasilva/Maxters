<?php

namespace Maxters\Providers;

use PHPLegends\Routes\Router;
use PHPLegends\Routes\UrlGenerator;

class RouterProvider extends AbstractProvider
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    public function register(\Pimple\Container $app)
    {
        $app['router'] = new Router;

        $app['current_route'] = null;

        $app['url'] = function ($app) {

            return new UrlGenerator($app['router'], $app['request']->getUri()->getHostWithScheme());
        };

        $this->map($app['router'], $app['config']['debug']);
    }

    protected function map(Router $router, $debug = false)
    {
        include_once APP_PATH . '/routes.php';

        $debug && $this->mapDebug($router);
    }

    public function mapDebug(Router $router)
    {
        $router->group(['prefix' => '_debug/'], function ($router) {

            include_once APP_PATH . '/routes.debug.php';    
        });
    }
}