<?php

require __DIR__ . '/vendor/autoload.php';


$configurator = new Nette\Config\Configurator;

$configurator->setTempDirectory(__DIR__ . '/temp_apache');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/app')
	->addDirectory(__DIR__ . '/presenters')
	->register();

$configurator->addConfig(__DIR__ . '/config/config_apache.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');
$container = $configurator->createContainer();

$container->application->run();
