<?php

include_once __DIR__ . '/constants.php';

include_once ROOT_PATH . '/vendor/autoload.php';

$app = new Maxters\Providers\Container();

$app->register(new Maxters\Providers\AppProvider($app));

return $app;
