<?php

namespace Iut;

use Iut\Http\Request;

class ControllerResolver implements ControllerResolverInterface
{
    private $matcher;
    private $controllers = [];

    public function __construct(RouteMatcher $matcher)
    {
        $this->matcher = $matcher;
    }

    public function resolve(Request $request)
    {
        $action = $this->matcher->match($request);
        $splitAction = explode('::', $action);
        $className = $splitAction[0];
        foreach ($this->controllers as $controller) {
            if ($className === '\\'.get_class($controller)) {
                $action = $splitAction[1];

                return [$controller, $action];
            }
        }

        throw new ControllerNotFound($className);
    }

    public function addController($controllerInstance)
    {
        if (!is_object($controllerInstance)) {
            throw new \Exception('$controllerInstance must be an object');
        }

        $this->controllers[] = $controllerInstance;
    }
}