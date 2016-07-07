<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app');

define('RESOURCES_PATH', ROOT_PATH . '/resources');

define('WEB_PATH', ROOT_PATH . '/web');

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Container();

$app->register(new Maxters\Providers\AppProvider($app));

if (file_exists($db_config_file = ROOT_PATH . '/db/generated-conf/config.php'))
{
    require_once $db_config_file;
}

return $app;
