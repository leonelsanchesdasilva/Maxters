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

	protected function entityMapper($entity = null)
	{	
		if ($entity !== null) {

			return $this->app['db']->mapper($entity);
		}

		return $this->app['db'];
	}

	protected function render($view, $data = [])
	{
		return $this->app['view']->create($view, $data);
	}

	public function session($data = null)
	{	
		if (is_string($data)) {

			return $this->app['session'][$data];

		} elseif (is_array($data)) {

			return $this->app['session']->getStorage()->merge($data);
		}

		return $this->app['session'];

	}

}
