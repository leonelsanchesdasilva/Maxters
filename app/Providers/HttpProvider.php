<?php

namespace Maxters\Providers;

use Pimple\Container;
use PHPLegends\Http\Request;
use PHPLegends\Http\CookieJar;
use PHPLegends\Http\ResponseHeaderCollection;

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

        $app['request'] = Request::createFromGlobals();

        $app['cookies'] = new CookieJar;

        $app['headers'] = function ($app) {

            $headers = new ResponseHeaderCollection;

            return $headers->setCookies($app['cookies']);
        };
    }
}
