<?php

namespace KB\Controller;

use KB\Http\Response;

class ErrorController extends AbstractController
{
    /**
     * @param \Exception $e
     * @return Response
     */
    public function routeNotFoundAction(\Exception $e)
    {
        return new Response(404, $e->getMessage());
    }

    /**
     * @param \Exception $e
     * @return Response
     */
    public function genericErrorAction(\Exception $e)
    {
        return new Response(500, 'Error occurred '. $e->getMessage());
    }
}