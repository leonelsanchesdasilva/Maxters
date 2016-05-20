<?php

namespace Maxters\Controllers;

use PHPLegends\View\View;
use PHPLegends\Http\JsonResponse;
use PHPLegends\Http\ServerRequest;

abstract class Controller
{
	protected $app;

	public function setApp(\Maxters\Container $app)
	{
		$this->app = $app;
	}

	protected function request($key = null)
	{
		$request = $this->app['request'];

		if (is_string($key)) {

			return $request->{'get' .  ucwords($key) . 'Params'}();
		}

		return $request;
	}

	protected function render($name, $data)
	{
		return $this->app['view']($name, $data);
	}

	protected function json($data, $code = 200, $flag = 0)
	{		

		$this->app['debug'] == false ?: $flag = 128;

		return new JsonResponse($data, $code, $flag);
	}
}