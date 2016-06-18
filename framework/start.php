<?php

define('ROOT_PATH', dirname(__DIR__));

define('APP_PATH', ROOT_PATH . '/app');

define('FRAMEWORK_PATH', ROOT_PATH . '/framework');

define('WEB_PATH', ROOT_PATH . '/web');

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Container();

$app->register(new Maxters\Providers\AppProvider($app));

return $app;