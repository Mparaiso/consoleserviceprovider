<?php

namespace Mparaiso\Provider;

use Silex\ServiceProviderInterface;
use Mparaiso\Console\Helper\ApplicationHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Silex\Application;
use Symfony\Component\Console\Application as ConsoleApplication;

class ConsoleServiceProvider implements ServiceProviderInterface{
    const INIT="consoleserviceprovider_init";
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app["console.helperset"]=$app->share(function($app){
            return new HelperSet(array(
                "app"=>new ApplicationHelper($app),
            ));
        });
        $app["console"]=$app->share(function(Application $app){
            $console = new ConsoleApplication("app console");
            $console->setHelperSet($app["console.helperset"]);
            $app["dispatcher"]->dispatch(self::INIT);
            return $console;
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
