<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

/**
 * @var \Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/vendor/autoload.php';

$env = getenv('SYMFONY_ENV') ?: 'prod';
$kernel = new AppKernel($env, 'prod' !== $env);
(new Dotenv())->load(__DIR__.'/.env');
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
