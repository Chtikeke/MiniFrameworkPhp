<?php

namespace KB\DemoBundle\Controllers;

use KB\Controller\AbstractController;
use KB\CoreDomain\User\User;

/**
 * Class DemoController
 */
class DemoController extends AbstractController
{
    /**
     * @return \KB\Http\Response
     */
    public function indexAction()
    {
        $user = User::create('test');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $users = $this->entityManager->getRepository('KB\CoreDomain\User\User')->findAll();

        return $this->view('demo.html.php', array('user' => $users));
    }
}