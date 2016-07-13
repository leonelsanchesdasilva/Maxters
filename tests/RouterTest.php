<?php

class RouterTest extends TestCase
{

    public function testGet()
    {
        
        $route = static::$app['router']->findByUri('/');

        $this->assertInstanceOf('PHPLegends\Routes\Route', $route);
    }
}