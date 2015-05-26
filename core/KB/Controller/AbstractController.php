<?php

namespace KB\Controller;

use KB\Http\Header;
use KB\Http\Response;
use KB\Views\ViewRendererInterface;

/**
 * Class AbstractController
 */
abstract class AbstractController
{
    /**
     * @var ViewRendererInterface
     */
    protected $viewRenderer;

    /**
     * @param $body
     * @param int $statusCode
     * @return Response
     */
    protected function createResponse($body, $statusCode = 200)
    {
        return new Response($statusCode, $body);
    }

    /**
     * @param $url
     * @param bool $isPermanent
     * @return Response
     */
    protected function createRedirectResponse($url, $isPermanent = false)
    {
        return new Response($isPermanent ? 301 : 302, null, [ new Header('Location', $url) ]);
    }

    /**
     * @param $viewName
     * @param array $params
     * @param int $statusCode
     * @return Response
     * @throws \Exception
     */
    protected function view($viewName, array $params = array(), $statusCode = 200)
    {
        if (is_null($this->viewRenderer)) {
            throw new \LogicException('No view renderer defined, you need set a instance of ViewRendererInterface to create a view');
        }

        $view = $this->viewRenderer->render($viewName, $params);

        return $this->createResponse($view, $statusCode);
    }
}