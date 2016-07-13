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

        $config = include RESOURCES_PATH . '/database.php';

        $app['db.config'] = function ($app) {

            return Setup::createAnnotationMetadataConfiguration(
                [APP_PATH . '/Models'], $app['config']['debug']
            );
        };


        $app['db'] = function ($app) use ($config) {

            $params = $config['connections'][$config['default']];

            return EntityManager::create($params, $app['db.config']);
        };
    }
}
