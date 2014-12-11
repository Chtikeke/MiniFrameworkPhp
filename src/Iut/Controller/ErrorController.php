<?php

namespace Iut\Controller;

use Iut\Http\Response;

class ErrorController extends AbstractController
{
    public function routeNotFoundAction()
    {
        return new Response(404, "La page n'existe pas");
    }

    public function genericErrorAction()
    {
        return new Response(500, "Une erreur iconnue est survenue");
    }
}