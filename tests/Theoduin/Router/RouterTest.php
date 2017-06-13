<?php

namespace Theoduin\Router;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /** @var Router */
    private $router;

    protected function setUp()
    {
        parent::setUp();
        $this->router = new Router();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->router = null;
    }

    /**
     * @covers Router::getRoutes
     */
    public function testGetRoutes()
    {
        $method = 'GET';
        $route = '/home';
        $target = function(){};
        $this->assertInternalType('array', $this->router->getRoutes());
        $this->router->get($route, $target);
        $this->assertEquals([['method' => $method, 'uri' => $route, 'action' => $target]], $this->router->getRoutes());
    }
}
