<?php

namespace Maxters\Providers;

use PHPLegends\Http\Session;
use PHPLegends\Session\Handlers\FileHandler;

class SessionProvider extends AbstractProvider
{
    /**
     *
     *
     * @param Container $app
     * @return void
     * */
    public function register(\Pimple\Container $app)
    {
        $app['session.handler'] = function () {

            return new FileHandler(ROOT_PATH . '/temp/session');
        };

        $app['session'] = function ($app) {

            $session = new Session($app['session.handler']);

            $session->setLifeTime($app['session.lifetime']);

            return $session;
        };

        $app['session.lifetime'] = '+10 minutes';
    }
}