<?php

namespace Iut;

use Iut\Http\Request;

class RouteNotFound extends \LogicException
{
    public function __construct(Request $request)
    {
        parent::__construct(
            sprintf(
                "La route '%s' n'existe pas.",
                $request->getUri()
            )
        );
    }
} 