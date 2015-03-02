<?php

namespace Spear\Skeleton\Controllers\Home;

use Spear\Silex\Application\Traits;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class Controller
{
    use
        Traits\RequestAware,
        LoggerAwareTrait;

    private
        $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;

        $this->logger = new NullLogger();
    }

    public function homeAction()
    {
        return $this->twig->render('home.html.twig');
    }
}