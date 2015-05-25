<?php

namespace KB\DemoBundle\Controllers;

use DI\Annotation\Inject;
use Doctrine\ORM\EntityManager;
use KB\Controller\AbstractController;
use KB\CoreDomain\User\User;

/**
 * Class DemoController
 */
class DemoController extends AbstractController
{
    /**
     * @var EntityManager
     *
     */
    private $entityManager;

    /**
     * @param $entityManager
     * @Inject("entity_manger")
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \KB\Http\Response
     */
    public function indexAction()
    {
        $user = User::create('test');

        var_dump($this);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $users = $this->entityManager->getRepository('KB\CoreDomain\User\User')->findAll();

        return $this->view('demo.html.php', array('user' => $users));
    }
}