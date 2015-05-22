<?php

namespace Iut\Views;


interface ViewRendererInterface
{
    public function render($viewName, array $parameters = []);
} 