<?php

namespace Spear\Skeleton\Controllers\Home;

use Silex\ControllerProviderInterface;
use Silex\Application;

class Provider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['controller.home'] = function() use($app) {
            $controller = new Controller($app['twig']);
            $controller->setRequest($app['request']);

            return $controller;
        };

        $controllers = $app['controllers_factory'];

        $controllers
            ->match('/', 'controller.home:homeAction')
            ->method('GET')
            ->bind('home');

        return $controllers;
    }
}
