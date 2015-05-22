<?php

namespace KB\Controller;

use Doctrine\ORM\EntityManager;
use KB\Http\Header;
use KB\Http\Request;
use KB\Http\Response;
use KB\Views\PhpViewRenderer;
use DI\Annotation\Inject;

/**
 * Class AbstractController
 */
abstract class AbstractController
{
    /**
     * @var PhpViewRenderer
     */
    protected $viewRenderer;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @Inject
     * @param PhpViewRenderer $viewRenderer
     */
    public function setViewRender(PhpViewRenderer $viewRenderer)
    {
        $this->viewRenderer = $viewRenderer;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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

    /**
     * @param $viewName
     * @param array $params
     * @param int $statusCode
     * @return Response
     * @throws \Exception
     */
    protected function view($viewName, array $params = array(), $statusCode = 200)
    {
        $view = $this->viewRenderer->render($viewName, $params);

        return $this->createResponse($view, $statusCode);
    }
}