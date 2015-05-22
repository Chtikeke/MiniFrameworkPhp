<?php

namespace KB;


use KB\Controller\AbstractController;
use KB\Logger\ChainLogger;
use KB\Logger\FileLogger;
use KB\Router\RouteNotFound;

/**
 * Class ExceptionHandler
 */
class ExceptionHandler
{
    /**
     * @var FileLogger
     */
    private $logger;

    /**
     * @var AbstractController
     */
    private $errorController;

    public function __construct(ChainLogger $logger, AbstractController $errorController)
    {
        $this->logger = $logger;
        $this->errorController = $errorController;
    }

    public function handle(\Exception $e)
    {
        $this->logger->error($e->getMessage());

        $action = "genericErrorAction";

        if ($e instanceof RouteNotFound) {
            $action = "routeNotFoundAction";
        }

        return [$this->errorController, $action];
    }
} 