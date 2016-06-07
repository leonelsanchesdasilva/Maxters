<?php

namespace Maxters\Providers;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

abstract class AbstractProvider implements ServiceProviderInterface
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    abstract public function register(Container $app);
}