<?php

namespace Maxters\Controllers;

use PHPLegends\View\View;
use PHPLegends\Http\JsonResponse;
use PHPLegends\Http\ServerRequest;
use Pimple\Container as PimpleContainer;

class Controller
{
	protected $app;

	public function setApp(PimpleContainer $app)
	{
		$this->app = $app;

		return $this;
	}

	protected function request($key = null)
	{
		$request = $this->app['request'];

		if (is_string($key)) {

			return $request->{'get' .  ucwords($key) . 'Params'}();
		}

		return $request;
	}

	public function render($view, $data = [])
	{
		return $this->app['view']->create($view, $data);
	}

	/**
	 *
	 * @return \Spot\Locator
	 * */
	public function db()
	{
		return $this->app['db'];
	}

}
