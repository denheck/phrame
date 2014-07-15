#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Phrame\Console\Command\Generate;
use Symfony\Component\Console\Application;
use Monolog\Logger;

$log = new Logger('generator');

$application = new Application();
$application->add(new Generate(null, $log));
$application->run();
