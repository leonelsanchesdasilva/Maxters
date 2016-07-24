<?php

namespace Maxters\Providers;

use Pimple\ServiceProviderInterface;

abstract class AbstractProvider implements ServiceProviderInterface
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    abstract public function register(\Pimple\Container $app);
}