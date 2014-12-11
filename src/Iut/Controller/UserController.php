<?php

namespace Iut\Controller;


use Iut\Http\Request;
use Iut\Http\Response;

class UserController extends AbstractController
{
    public function registerAction()
    {
        return new Response(
            200,
            $this->viewRenderer->render(
                'register.html.php',
                ['titre' => 'Inscription']
            )
        );
    }

    public function viewProfileAction()
    {
        return $this->createRedirectResponse('/register', false);

//        return new Response(
//            200,
//            $this->viewRenderer->render(
//                'viewProfile.html.php',
//                ['titre' => 'Profil']
//            )
//        );
    }
} 