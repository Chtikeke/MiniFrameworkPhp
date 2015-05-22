<?php

namespace KB\Router;

use KB\Http\Request;

/**
 * Class RouteNotFound
 */
class RouteNotFound extends \LogicException
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct(sprintf("Route '%s' is not found", $request->getUrl()));
    }
} 