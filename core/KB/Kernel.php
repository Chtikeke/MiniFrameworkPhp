<?php

namespace KB;

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Cache;
use KB\Configuration\PhpLoader;
use KB\Configuration\YamlLoader;
use KB\Controller\AbstractController;
use KB\Controller\ErrorController;
use KB\Router\Route;
use KB\Views\PhpViewRenderer;
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
     * @var bool
     */
    private $booted = false;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct()
    {
        $this->controllers = array(
            'KB\\DemoBundle\\DemoController',
        );
    }

    /**
     * Boot the current kernel
     */
    private function boot()
    {
        if (true === $this->booted) {
            return;
        }
        
        $appConfigurationLoader = new YamlLoader([__DIR__ . '/../../config/app.yml']);
        $containerConfigurationLoader = new PhpLoader([__DIR__.'/config/config.php']);

        $this->initializeContainer(array_merge($appConfigurationLoader->load(), $containerConfigurationLoader->load()));

        //$this->container->set('kernel', $this);
        $this->container->set('request', $this->request);

        $this->booted = true;
    }

    /**
     * Initiliaze the container
     * @param array $configuration
     */
    private function initializeContainer(array $configuration)
    {
        $builder = new ContainerBuilder();
        $builder->setDefinitionCache(new ArrayCache());
        $builder->addDefinitions($configuration);

        $this->container = $builder->build();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->request = $request;

        if (false === $this->booted) {
            $this->boot();
        }

        $routes = [];

        foreach ($this->container->get('routes') as $route) {
            $routes[] = new Route($route['url'], $route['method'], $route['action']);
        }

        try {
            $matcher = new RouteMatcher($routes);
            $controllerResolver = new ControllerResolver($matcher, $this->container);
            $viewRender = new PhpViewRenderer(__DIR__ . '/../..' . $this->container->get('views')['directory']);

            /** @var AbstractController $controller */
            foreach ($this->controllers as $controller) {
                //TODO inject dependencies with PHP DI
                //$controller->setViewRender($viewRender);
                //$controller->setRequest($request);
                //$controller->setEntityManager($this->container->get('entity_manager'));
                $controllerResolver->addController($controller);
            }

            $resolvedController = $controllerResolver->resolve($request);
            $response = call_user_func($resolvedController);

        } catch (\Exception $e) {
            $chainLogger = new ChainLogger();
            $chainLogger->addLogger(new FileLogger(__DIR__ . '/../..' . $this->container->get('logger')['filelogger']['pathname']));

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
