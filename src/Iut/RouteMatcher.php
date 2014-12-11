<?php

namespace Iut;

use Iut\Http\Request;

class RouteMatcher
{
    private $routes;

    public function  __construct(array $routes)
    {
        $this->routes = $routes;
    }

    // Si on ne matche pas, ça va nous retourne null
    public function match(Request $request)
    {
        /** @var Route $route */
        foreach($this->routes as $route)
        {
           if($route->getUrl() === $request->getUri()
           && $route->getMethod() === $request->getMethod()){
               return $route->getAction();
           }
        }

        throw new RouteNotFound($request);
    }
} 