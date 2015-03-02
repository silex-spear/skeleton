<?php

namespace Spear\Skeleton;

use Puzzle\Configuration;

class Console
{
    private
        $app,
        $configuration;

    public function __construct(Application $dic)
    {
        $this->configuration = $dic['configuration'];

        $this->app = new \Symfony\Component\Console\Application('silex-spear-app');

        $this->app->add(new Commands\GreetCommand());
    }

    public function run()
    {
        $this->app->run();
    }
}