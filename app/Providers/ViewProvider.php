<?php

namespace Maxters\Providers;

use Pimple\Container;
use PHPLegends\View\Factory;
use PHPLegends\View\Finder;
use PHPLegends\View\Data;

class ViewProvider extends AbstractProvider
{
    /**
     * 
     * 
     * @param Container $app
     * @return void
     * */
    public function register(Container $app)
    {
        $app['view.finder'] = function ($app) {

            $config = $app['config']['view'];

            return new Finder($config['extensions'], $config['default_path']);
        };

        $app['view.data'] = new Data;
    
        $app['view'] = function ($app) {

            $config = $app['config']['view'];

            return new Factory($app['view.finder'], $app['view.data']);
        };

        $app['view.data']->define('app', $app);

        $this->sharedData($app['view.data']);
    }

    /**
     * É o melhor lugar para definir dados globais para view
     * 
     * @param PHPLegends\View\Data $data
     * @return void
     * */
    protected function sharedData(Data $data)
    {   
        // Não é a mesma coisa que "set"
        // Se você usar define, está dizendo que não pode ser removido ou sobrescrito
        // Isso é útil em casos onde a substituição não é desejada

        $data->define('framework', 'Maxters');
    }
}