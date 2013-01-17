<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/BuildCommand.php';
require_once __DIR__ . '/StamperTemplate.php';
require_once __DIR__ . '/Stamper_Twig_Loader.php';

use Spol\Stamper\Command;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new BuildCommand());
$application->run();
