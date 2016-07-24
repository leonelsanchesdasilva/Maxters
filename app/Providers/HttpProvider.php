<?php

namespace Maxters\Providers;

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
    public function register(\Pimple\Container $app)
    {

        $app['request'] = Request::createFromGlobals();

        $app['cookies'] = new CookieJar;

        $app['headers'] = function ($app) {

            $headers = new ResponseHeaderCollection;

            $headers['content-type'] = sprintf(
                'text/html; charset=%s', $app['config']['charset']
            );

            return $headers->setCookies($app['cookies']);
        };
    }
}
