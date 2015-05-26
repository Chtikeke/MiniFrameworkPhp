<?php

namespace KB\Views;

/**
 * Class PhpViewRenderer
 */
class PhpViewRenderer implements ViewRendererInterface
{
    /**
     * @var string
     */
    private $viewsDirectory;

    /**
     * @param $viewsDirectory
     */
    public function __construct($viewsDirectory)
    {
        $this->viewsDirectory = $viewsDirectory;
    }

    /**
     * @param $viewName
     * @param array $parameters
     * @throws \Exception
     * @return mixed|string
     */
    public function render($viewName, array $parameters = [])
    {
        if (!file_exists($this->viewsDirectory . $viewName)) {
            throw new \Exception(sprintf('File %s does not exist', $this->viewsDirectory . $viewName));
        }

        ob_start();
        include $this->viewsDirectory . $viewName;
        $view = ob_get_contents();
        ob_clean();

        return $view;
    }
}