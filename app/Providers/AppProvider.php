<?php

namespace Maxters\Providers;

use PHPLegends\Http\Response;
use Pimple\Container;

class AppProvider extends AbstractProvider
{
	protected $providers = [
		'Maxters\Providers\RouterProvider',
		'Maxters\Providers\ViewProvider',
		'Maxters\Providers\HttpProvider',
	];

	/**
	 * 
	 * 
	 * @param Container $app
	 * @return void
	 * */
	public function register(Container $app)
	{
		$this->registryConfiguration($app);

		$this->addProviders($app);
	}

	public function addProviders(Container $app)
	{
		foreach ($this->providers as $provider)
		{
			$app->register(new $provider);
		}
	}

	protected function registryConfiguration(Container $app)
	{
		$app['config'] = include APP_PATH . '/config.php';
	}

}