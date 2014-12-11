<?php

namespace Iut\Controller;

class DefaultController extends AbstractController
{

    public function aboutAction()
    {
        $view = $this->viewRenderer->render('about.html.php', [
            'titre' => 'Page about from renderer',
            'headTitle' => 'About',
        ]);

        return $this->createResponse($view);
    }

    public function homepageAction()
    {
        $view = $this->viewRenderer->render('homepage.html.php', [
            'titre' => 'Homepage',
            'headTitle' => 'About',
        ]);

        return $this->createResponse($view);
    }
}