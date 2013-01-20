<?php

require __DIR__ . '/vendor/autoload.php';

$config = new Nette\Config\Configurator();
$config->setDebugMode(TRUE);
$config->setTempDirectory(__DIR__ . '/temp');
$config->addConfig(__DIR__ . '/config/config.neon');
$config->addConfig(__DIR__ . '/config/config.local.neon');
$config->createRobotLoader()
	->addDirectory(__DIR__ . '/app')
	->addDirectory(__DIR__ . '/presenters')
	->register();
$container = $config->createContainer();

$server = (object) $container->parameters['server'];


$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket, $loop);

$http->on('request', function ($req, $res) use ($container) {
	if ($req->getMethod() === 'POST') {
		$req->on('data', function($data) use ($container, $req, $res) {
			$container->httpRequest->setPostData($data);
			runApplication($container, $req, $res);
		});

	} else {
		runApplication($container, $req, $res);
	}

	/*
	$kmem = memory_get_usage(true) / 1024;
	echo "Memory: $kmem KiB\n";
	// */
});

$socket->listen($server->port);
echo "Server running at http://127.0.0.1:{$server->port}\n";

$loop->run();


function runApplication($container, $req, $res)
{
	try {
		$container->application->runAsync($req, $res);
		//echo "\033[32m{$req->getPath()}\033[0m\n";

	} catch (Exception $e) {
		$res->writeHead(500, array('Content-Type' => 'text/plain'));
		$res->end("Server error.");
		echo "\033[1;31m{$req->getPath()}\033[0m - {$e->getMessage()}\n";
	}
}
