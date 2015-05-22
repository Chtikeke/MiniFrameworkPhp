<?php

namespace KB;

use KB\Controller\ErrorController;
use KB\DemoBundle\Controllers\DemoController;
use KB\Views\ViewRendererInterface;
use KB\Controller\ControllerResolver;
use KB\Http\Request;
use KB\Logger\ChainLogger;
use KB\Logger\FileLogger;
use KB\Router\RouteMatcher;

/**
 * Class Kernel
 */
class Kernel
{
    /**
     * @var
     */
    private $request;

    /**
     * @var array
     */
    private $controllers;

    /**
     * @var ViewRendererInterface
     */
    private $viewRenderer;
    /**
     * @var array
     */
    private $routes;

    /**
     * @param ViewRendererInterface $viewRenderer
     * @param array $routes
     */
    public function __construct(ViewRendererInterface $viewRenderer, array $routes = array())
    {
        $this->viewRenderer = $viewRenderer;
        $this->routes = $routes;

        $this->controllers = array(
            new DemoController($viewRenderer),
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->request = $request;

        try {
            $matcher = new RouteMatcher($this->routes);
            $controllerResolver = new ControllerResolver($matcher);

            foreach ($this->controllers as $controller) {
                $controllerResolver->addController($controller);
            }

            $resolvedController = $controllerResolver->resolve($request);
            $response = call_user_func($resolvedController);

        } catch (\Exception $e) {
            $chainLogger = new ChainLogger();
            $chainLogger->addLogger(new FileLogger(__DIR__ . "/../../error.log"));


            $exceptionHandler = new ExceptionHandler(
                $chainLogger,
                new ErrorController($this->viewRenderer)
            );

            $controllerAction = $exceptionHandler->handle($e);
            $response = call_user_func($controllerAction, $e);
        }

        return $response;
    }
}