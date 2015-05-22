<?php

namespace KB\Views;

/**
 * Interface ViewRendererInterface
 */
interface ViewRendererInterface
{
    /**
     * @param $viewName
     * @param array $parameters
     * @return mixed
     */
    public function render($viewName, array $parameters = []);
} 