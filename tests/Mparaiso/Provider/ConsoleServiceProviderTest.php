<?php

namespace Mparaiso\Provider;

class ConsoleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Silex\Application;
     */
    protected $app;

    function setUp()
    {
        parent::setUp();
        $this->app = new \Silex\Application();
        $this->app->register(new ConsoleServiceProvider);
    }

    function testRegister()
    {
        $this->assertTrue($this->app['console'] != NULL);
        $this->assertTrue($this->app['console.helperset'] != NULL);
    }
}