<?php

namespace Iut\Views;

class PhpViewRenderer implements ViewRendererInterface
{
    private $viewsDirectory;

    public function  __construct($viewsDirectory)
    {
        $this->viewsDirectory = $viewsDirectory;
    }

    public function render($viewName, array $parameters = [])
    {
        ob_start();
        include $this->viewsDirectory . $viewName;
        $view = ob_get_contents();
        ob_clean();

        return $view;
    }
}