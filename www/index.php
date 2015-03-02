<?php

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Spear\\Silex\\Application\\', __DIR__ . '/../../spear-application/src/');

use Puzzle\Configuration\Yaml;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local;
use Spear\Skeleton\Application;

$configurationFilesStorage = new Filesystem(new Local(__DIR__ . '/../config'));
$configuration = new Yaml($configurationFilesStorage);

$rootDir = realpath(__DIR__ . '/..');

$app = new Application($configuration, $rootDir);

$app->run();
