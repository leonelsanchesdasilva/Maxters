<?php

namespace Maxters\Controllers;

class Home extends Controller
{
	public function index()
	{
		return $this->render('home/index', ['framework' => 'Maxters']);
	}
}