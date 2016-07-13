<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app');

define('RESOURCES_PATH', ROOT_PATH . '/resources');

define('WEB_PATH', ROOT_PATH . '/web'); 

define('DB_PATH', ROOT_PATH . '/db'); 

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Container();

$app->register(new Maxters\Providers\AppProvider($app));

return $app;
