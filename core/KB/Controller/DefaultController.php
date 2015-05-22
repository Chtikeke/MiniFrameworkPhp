<?php

namespace KB\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends AbstractController
{

    /**
     * @return \KB\Http\Response
     */
    public function aboutAction()
    {
        $view = $this->viewRenderer->render('about.html.php', [
            'titre' => 'Page about from renderer',
            'headTitle' => 'About',
        ]);

        return $this->createResponse($view);
    }

    /**
     * @return \KB\Http\Response
     */
    public function homepageAction()
    {
        $view = $this->viewRenderer->render('homepage.html.php', [
            'titre' => 'Homepage',
            'headTitle' => 'About',
        ]);

        return $this->createResponse($view);
    }
}