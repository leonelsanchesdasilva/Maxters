<?php

namespace Maxters\Providers;

use Pimple\Container;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\ClassLoader;

class DatabaseProvider extends AbstractProvider
{
    public function register(Container $app)
    {

        $app['db.params'] = include RESOURCES_PATH . '/database.php';

        $app['db.config'] = function ($app) {

            $default = $app['db.params']['default'];

            $params = $app['db.params']['connections'][$default];

            $config = new \Spot\Config();
            
            $config->addConnection($default, $params);

            return $config; 
        };

        $app['db'] = function ($app) {

            return new \Spot\Locator($app['db.config']);
        };
    }
}
