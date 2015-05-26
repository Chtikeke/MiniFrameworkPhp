<?php

namespace KB;

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Cache;
use KB\Configuration\PhpLoader;
use KB\Configuration\YamlLoader;
use KB\Controller\ErrorController;
use KB\Router\Route;
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
     * @var Request
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
        $builder->useAnnotations(true);

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

        if (!is_null($this->container->get('routes'))) {
            foreach ($this->container->get('routes') as $route) {
                $routes[] = new Route($route['url'], $route['method'], $route['action']);
            }
        }

        try {
            $matcher = new RouteMatcher($routes);
            $controllerResolver = new ControllerResolver($matcher, $this->container);

            foreach ($this->controllers as $controllerName) {
                $controllerResolver->addController($controllerName);
            }

            $resolvedController = $controllerResolver->resolve($request);
            $response = call_user_func(array($resolvedController[0], $resolvedController[1]), $resolvedController[2]);

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
