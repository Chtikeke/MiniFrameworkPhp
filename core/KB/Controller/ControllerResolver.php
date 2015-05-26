<?php

namespace KB\Controller;

use KB\Http\Request;
use KB\Router\RouteMatcher;
use Interop\Container\ContainerInterface;

/**
 * Class ControllerResolver
 */
class ControllerResolver implements ControllerResolverInterface
{
    /**
     * @var RouteMatcher
     */
    private $matcher;

    /**
     * @var array
     */
    private $controllers = [];

    /**
     * @param RouteMatcher $matcher
     * @param ContainerInterface $container
     */
    public function __construct(RouteMatcher $matcher, ContainerInterface $container = null)
    {
        $this->matcher = $matcher;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return array|callable
     */
    public function resolve(Request $request)
    {
        $matchedAction = $this->matcher->match($request);
        $splitAction = explode('::', $matchedAction[0]);
        $className = $splitAction[0];

        if (is_null($this->container)) {
            foreach ($this->controllers as $controller) {
                if ($className == '\\'.get_class($controller)) {
                    $action = $splitAction[1];

                    return [$controller, $action, $matchedAction[1]];
                }
            }
        } else if ($this->container->has($className)) {
            return [$this->container->get($className), $matchedAction[0], $matchedAction[1]];
        }
        
        throw new ControllerNotFound($className);
    }

    /**
     * @param object | string $controller
     * @throws \Exception
     */
    public function addController($controller)
    {
        if (is_object($controller)) {

            if (is_null($this->container)) {
                $this->controllers[] = $controller;
            } else {
                $this->container->set('\\' . get_class($controller), $controller);
            }

        } else {
            $this->container->set('\\' . $controller, $controller);
        }
    }
}
