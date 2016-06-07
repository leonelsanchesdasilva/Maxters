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
        $app['router'] = function () {
            return new Router;
        };

        $this->map($app['router']);
    }

    protected function map(Router $router)
    {
        call_user_func(function () use($router)
        {
            include_once APP_PATH . '/routes.php';
        });
    }
}