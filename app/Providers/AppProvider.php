<?php

namespace Maxters\Providers;

use PHPLegends\Http\Response;

class AppProvider extends AbstractProvider
{
	/**
	 * 
	 * @var array
	 * */
	protected $providers = [
		'Maxters\Providers\DatabaseProvider',
		'Maxters\Providers\HttpProvider',
		'Maxters\Providers\RouterProvider',
		'Maxters\Providers\ViewProvider',
		'Maxters\Providers\SessionProvider',
	];

	/**
	 *
	 * @param Container $app
	 * @return void
	 * */
	public function register(\Pimple\Container $app)
	{
		$this->registryConfiguration($app);

		$this->addProviders($app);
	}

	/**
	 * 
	 * @param Container $app
	 * */
	public function addProviders(Container $app)
	{
		foreach ($this->providers as $provider)
		{
			$app->register(new $provider);
		}
	}

	protected function registryConfiguration(Container $app)
	{
		$configFile = RESOURCES_PATH . '/config.php';

		if (! file_exists($configFile)) {

			throw new \RuntimeException(
				"Configuration file '{$configFile}' doesn't exists"
			);
		}

		$app['config'] = include_once $configFile;
	}

}