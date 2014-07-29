#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Phrame\Console\Command\Build;
use Symfony\Component\Console\Application;
use Monolog\Logger;

$log = new Logger('builder');

$application = new Application();
$application->add(new Build(null, $log));
$application->run();
