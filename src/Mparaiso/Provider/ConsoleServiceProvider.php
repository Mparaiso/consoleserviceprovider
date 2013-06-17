<?php

namespace Mparaiso\Provider;

use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Mparaiso\Console\Command\ListServicesCommand;
use Mparaiso\Console\Command\RouterDebugCommand;
use Mparaiso\Console\Helper\ApplicationHelper;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;

class ConsoleServiceProvider implements ServiceProviderInterface
{

    const INIT = "consoleserviceprovider_init";

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
        $app["console.helperset"] = $app->share(function ($app) {
                return new HelperSet(array(
                    "app"       => new ApplicationHelper($app),
                    "formatter" => new FormatterHelper(),
                    "dialog"    => new DialogHelper(),
                ));
            }
        );
        $app["console"] = $app->share(function ($app) {
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
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
        if (isset($app['db'])) {
            $app['console.helperset'] = $app->share(
                $app->extend("console.helperset", function ($hs, $app) {
                    /* @var HelperSet $hs */
                    $hs->set(new ConnectionHelper($app["db"]), "db");
                    return $hs;
                }));
            $app["console"] = $app->share($app->extend("console", function ($console, $app) {
                /* @var \Symfony\Component\Console\Application $console */
                $console->add(new ImportCommand);
                $console->add(new ReservedWordsCommand);
                $console->add(new RunSqlCommand);
                return $console;
            }));
        }
    }

}
