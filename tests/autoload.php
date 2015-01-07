<?php

/** @var $loader \Composer\Autoload\ClassLoader */
$baseDir = dirname(dirname(__FILE__));
$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->setPsr4("Acquia\\Cloud\\Api\\Tests\\", array($baseDir . '/tests'));
