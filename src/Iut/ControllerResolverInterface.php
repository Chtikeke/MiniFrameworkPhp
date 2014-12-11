<?php

namespace Iut;

use Iut\Http\Request;

interface ControllerResolverInterface
{
    /**
     * @param Request $request
     * @return callable
     */
    public function resolve(Request $request);
} 