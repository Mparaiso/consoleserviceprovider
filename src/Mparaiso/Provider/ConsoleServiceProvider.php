<?php

namespace Mparaiso\Provider;

use Mparaiso\Console\Command\ListServicesCommand;
use Mparaiso\Console\Command\RouterDebugCommand;
use Mparaiso\Console\Helper\ApplicationHelper;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;

class ConsoleServiceProvider implements ServiceProviderInterface {

    const INIT = "consoleserviceprovider_init";

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app) {
        $app["console.helperset"] = $app->share(function($app) {
                    return new HelperSet(array(
                        "app" => new ApplicationHelper($app),
                        "formatter" => new FormatterHelper(),
                    ));
                }
        );
        $app["console"] = $app->share(function($app) {
                    $console = new ConsoleApplication("app console");
                    $console->setHelperSet($app["console.helperset"]);
                    $console->add(new RouterDebugCommand);
                    $console->add(new ListServicesCommand);
                    return $console;
                }
        );
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app) {
        // TODO: Implement boot() method.
    }

}
