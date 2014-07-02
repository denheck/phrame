#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Phrame\Console\Command\Generate;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Generate());
$application->run();
