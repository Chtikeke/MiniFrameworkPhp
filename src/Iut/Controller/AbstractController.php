<?php

namespace Iut\Controller;

use Iut\Http\Header;
use Iut\Http\Response;
use Iut\Views\ViewRendererInterface;

abstract class AbstractController
{
    protected $viewRenderer;

    public function __construct(ViewRendererInterface $viewsDirectory)
    {
        $this->viewRenderer = $viewsDirectory;
    }

    protected function createResponse($body)
    {
        return new Response(200, $body);
    }

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