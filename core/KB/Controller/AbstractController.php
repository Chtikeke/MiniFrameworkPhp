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
     * @param ViewRendererInterface $viewRenderer
     */
    public function __construct(ViewRendererInterface $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

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
}