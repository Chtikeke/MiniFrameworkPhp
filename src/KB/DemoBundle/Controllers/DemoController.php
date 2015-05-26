<?php

namespace KB\DemoBundle\Controllers;

use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use KB\Controller\AbstractController;
use KB\Views\ViewRendererInterface;

/**
 * Class DemoController
 */
class DemoController extends AbstractController
{
    /**
     * @var ViewRendererInterface
     * @Inject("@php_view_render")
     */
    protected $viewRenderer;

    /**
     * @var EntityManager
     * @Inject("@entity_manager")
     */
    private $entityManager;

    /**
     * @return \KB\Http\Response
     */
    public function indexAction()
    {
        $users = $this->entityManager->getRepository('KB\CoreDomain\User\User')->findAll();

        return $this->view('demo.html.php', array('users' => $users));
    }
}