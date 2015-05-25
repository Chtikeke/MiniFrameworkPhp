<?php

namespace KB;

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Cache;
use KB\Config\YamlLoader;
use KB\Controller\AbstractController;
use KB\Controller\ErrorController;
use KB\DemoBundle\Controllers\DemoController;
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
            new DemoController(),
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
        
        $configLoader = new YamlLoader([__DIR__ . '/../../config/app.yml']);
        
        $this->initializeContainer($configLoader->load());
        
        $this->container->set('doctrine.metadataconfig', DI\factory(function (Container $c) {
            return Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../../src"), true)
        });
        
        $this->container->set('entity_manager', DI\factory(function (Container $c) {
            return EntityManager::create($c->get('doctrine')['default'], $c->get('doctrine.metadataconfig'));
        });

        $this->container->set('kernel', $this);
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
            $controllerResolver = new ControllerResolver($matcher);
            $viewRender = new PhpViewRenderer(__DIR__ . '/../..' . $this->container->get('views')['directory']);

            /** @var AbstractController $controller */
            foreach ($this->controllers as $controller) {
                //Set dependencies (PHP-DI doesn't working, so sad :( )
                $controller->setViewRender($viewRender);
                $controller->setRequest($request);
                $controller->setEntityManager($this->container->get('entity_manager'));

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
