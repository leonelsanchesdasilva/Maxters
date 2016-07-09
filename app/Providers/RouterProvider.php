<?php

namespace Maxters\Providers;

use Pimple\Container;
use PHPLegends\Routes\Router;

class RouterProvider extends AbstractProvider
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    public function register(Container $app)
    {
        $app['router'] = new Router;

        $this->map($app['router'], $app['config']['debug']);
    }

    protected function map(Router $router, $debug = false)
    {
        include_once APP_PATH . '/routes.php';

        $debug && $this->mapDebug($router);
    }

    public function mapDebug(Router $router)
    {
        include_once APP_PATH . '/routes.debug.php';    
    }
}