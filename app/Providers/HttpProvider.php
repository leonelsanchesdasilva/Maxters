<?php

namespace Maxters\Providers;

use Pimple\Container;
use PHPLegends\Http\ServerRequest;

class HttpProvider extends AbstractProvider
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    public function register(Container $app)
    {
        $app['request'] = function ($c) {
            return ServerRequest::createFromGlobals();
        };
    }
}