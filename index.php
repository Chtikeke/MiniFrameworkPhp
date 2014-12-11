<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require __DIR__ . '/vendor/autoload.php';

    use Iut\Http\Request;
    use Iut\Route;
    use Iut\ControllerResolver;
    use \Iut\ExceptionHandler;
    use Iut\RouteMatcher;
    use Iut\Logger\FileLogger;
    use Iut\Logger\PDOLogger;
    use Iut\Logger\ChainLogger;
    use Iut\Controller\DefaultController;
    use Iut\Controller\ErrorController;
    use Iut\Controller\UserController;
    use Iut\Views\PhpViewRenderer;
    use Iut\Config\Configuration;
    use Iut\Config\YamlLoader;

    $configFile = __DIR__ . "/config/app.yml";
    $config = new Configuration( new YamlLoader([$configFile]));

    $request = Request::createFromGlobals();

    $viewsDirectory = __DIR__ . '/config/' . $config->getSection('views')['directory'];

    $routes = [];

    foreach ($config->getSection('routes') as $route) {
        $routes[] = new Route($route['url'], $route['method'], $route['action']);
    }

    $viewRenderer = new PhpViewRenderer($viewsDirectory);

    try {
        $matcher = new RouteMatcher($routes);
        $controllerResolver = new ControllerResolver($matcher);
        $controllerResolver->addController(
            new DefaultController($viewRenderer)
        );
        $controllerResolver->addController(
            new UserController($viewRenderer)
        );
        $resolvedController = $controllerResolver->resolve($request);
        $response = call_user_func($resolvedController);
    } catch (\Exception $e) {
        $chainLogger = new ChainLogger();
        $chainLogger->addLogger(new FileLogger(__DIR__ . "/error.log"));
        $chainLogger->addLogger(
            new PDOLogger(
                new PDO(
                    'mysql:dbname=iut;host=172.16.1.127',
                    'root',
                    ''
                )
            )
        );
        $exceptionHandler = new ExceptionHandler(
            $chainLogger,
            new ErrorController(__DIR__ . '/views/')
        );
        $controllerAction = $exceptionHandler->handle($e);
        $response = call_user_func($controllerAction);
    }

    $response->send();