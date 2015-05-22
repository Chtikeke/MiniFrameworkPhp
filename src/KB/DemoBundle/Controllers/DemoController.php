<?php

namespace KB\DemoBundle\Controllers;

use KB\Controller\AbstractController;

class DemoController extends AbstractController
{
    public function indexAction()
    {
        $view = $this->viewRenderer->render('demo.html.php');

        return $this->createResponse($view);
    }
}