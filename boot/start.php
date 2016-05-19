<?php
use PHPLegends\Routes\Router;
use PHPLegends\Legendary\View;

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app/');
define('WEB_PATH', ROOT_PATH . '/app/');

header('Content-Type: text/html; charset=UTF-8');

require_once ROOT_PATH . '/vendor/autoload.php';

View::config([ 'path' => APP_PATH . '/views' ]);

$router = new Router;

require_once APP_PATH . '/app.php';

return $router;
