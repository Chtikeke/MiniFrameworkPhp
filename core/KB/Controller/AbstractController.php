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
     * @param ViewRendererInterface $viewsDirectory
     */
    public function __construct(ViewRendererInterface $viewsDirectory)
    {
        $this->viewRenderer = $viewsDirectory;
    }

    /**
     * @param $body
     * @param int $code
     * @return Response
     */
    protected function createResponse($body, $code = 200)
    {
        return new Response($code, $body);
    }

    /**
     * @param $url
     * @param bool $isPermanent
     * @return Response
     */
    protected function createRedirectResponse($url, $isPermanent = false)
    {
        return new Response(
            $isPermanent ? 301 : 302,
            null,
            [
                new Header('Location', $url)
            ]
        );
    }
}