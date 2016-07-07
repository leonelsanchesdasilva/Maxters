<?php

namespace Maxters\Providers;

use PHPLegends\Http\Response;
use Pimple\Container;

class DatabaseProvider extends AbstractProvider
{
    public function register(Container $app)
    {
        $app['db.config'] = function () {

            $config = include RESOURCES_PATH . '/database.php';

            $dbConfig = new \Spot\Config();

            foreach ($config['connections'] as $name => $connectionData) {

                $dbConfig->addConnection($name, $connectionData);
            }

            return $dbConfig;

        };

        $app['db'] = function ($app) {

            return new \Spot\Locator($app['db.config']);
        };
    }
}
