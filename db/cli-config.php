<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap

require_once __DIR__ . '/../boot/start.php';

//new ClassLoader('CustomLib', '/path/to/custom/lib')

return ConsoleRunner::createHelperSet($app['db']);