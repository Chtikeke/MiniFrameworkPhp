<?php

namespace KB\DemoBundle\Controllers;

use KB\Controller\AbstractController;

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
        return $this->view('demo.html.php');
    }
}