<?php

namespace Maxters\Controllers;

class Home extends Controller
{
	public function index()
	{	
		return $this->render('home/index', []);
	}	

	public function jsonExample()
	{
		return ['nome' => 'Wallace'];
	}
}