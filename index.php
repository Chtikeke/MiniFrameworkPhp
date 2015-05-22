<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use KB\Config\Configuration;
use KB\Config\YamlLoader;
use KB\Http\Request;
use KB\Kernel;
use KB\Router\Route;
use KB\Views\PhpViewRenderer;

$configFile = __DIR__ . "/config/app.yml";
$config = new Configuration(new YamlLoader([$configFile]));

$viewsDirectory = __DIR__ . '/config/' . $config->getSection('views')['directory'];

$routes = [];

foreach ($config->getSection('routes') as $route) {
    $routes[] = new Route($route['url'], $route['method'], $route['action']);
}

$viewRenderer = new PhpViewRenderer($viewsDirectory);

$request = Request::createFromGlobals();

$kernel = new Kernel($viewRenderer, $routes);
$response = $kernel->handle($request);

$response->send();