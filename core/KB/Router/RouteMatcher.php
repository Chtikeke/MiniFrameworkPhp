<?php

namespace KB\Router;

use KB\Http\Request;

/**
 * Class RouteMatcher
 */
class RouteMatcher
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function match(Request $request)
    {
        /** @var Route $route */
        foreach($this->routes as $route)
        {
            $urlToMatch = str_replace('/', '\\/', $route->getUrl());

            if (preg_match('/' . $urlToMatch . '$/', $request->getUrl(), $matches) && $route->getMethod() === $request->getMethod()) {
               return [$route->getAction(), array_splice($matches, 1)];
            }
        }

        throw new RouteNotFound($request);
    }
} 