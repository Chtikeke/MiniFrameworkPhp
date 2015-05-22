<?php

namespace KB\Controller;
use KB\Http\Request;

/**
 * Interface ControllerResolverInterface
 */
interface ControllerResolverInterface
{
    /**
     * @param Request $request
     * @return callable
     */
    public function resolve(Request $request);
} 