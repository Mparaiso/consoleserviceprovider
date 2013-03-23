<?php

namespace Mparaiso\Console\Helper;

use Symfony\Component\Console\Helper\Helper;
use Silex\Application;

class ApplicationHelper extends Helper{

    /**
     * @var \Silex\Application
     */
    protected $app;

    function __construct(Application $app){
        $this->app = $app;
    }

    function getApplication()
    {
        return $this->app;
    }

    function getName()
    {
        return "app";
    }
}