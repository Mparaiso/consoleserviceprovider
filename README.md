ConsoleServiceProvider
======================

Symfony Console integration for Silex

author : MParaiso
contact: mparaiso@online.fr

status: Work in Progress

### USAGE


        $app = new \Silex\Application();
        $app->register(new ConsoleServiceProvider);

        # in your console application file :
        $this->app["console"]->run();

        # access silex app from a command
        $app = $this->getHelper("app")->getApplication();



###Services

    ***console*** : Symfony\Component\Console\Application
    ***console.helperset*** : Symfony\Component\Console\Helper\HelperSet

TODO

+ list services in alphabetic order in ListServicesCommand
