<?php

namespace Spear\Skeleton\Controllers\Home;

use Spear\Silex\Application\Traits;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Spear\Silex\Provider\Traits\TwigAware;

class Controller
{
    use
        Traits\RequestAware,
        TwigAware,
        LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function homeAction()
    {
        return $this->render('home.html.twig');
    }
}
