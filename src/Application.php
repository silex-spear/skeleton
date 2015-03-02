<?php

namespace Spear\Skeleton;

use Spear\Silex\Application\AbstractApplication;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Spear\Silex\Provider;
use Puzzle\Configuration;
use Silex\Provider\UrlGeneratorServiceProvider;

class Application extends AbstractApplication
{
    protected function registerProviders()
    {
        $this->register(new SessionServiceProvider());

        $this->register(new Provider\DBAL());
        $this->register(new Provider\Twig());
        $this->register(new Provider\AsseticServiceProvider());
    }

    protected function initializeServices()
    {
        $this->configureTwig();
    }

    private function configureTwig()
    {
        $this['twig.path.manager']->addPath(array(
            $this['root.path'] . 'views/',
        ));
    }

    protected function mountControllerProviders()
    {
        $this->mount('/', new Controllers\Home\Provider());
    }
}
