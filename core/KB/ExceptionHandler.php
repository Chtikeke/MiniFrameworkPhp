<?php

namespace KB;


use KB\Logger\FileLogger;

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
     * @var
     */
    private $errorController;

    public function __construct(FileLogger $logger, $errorController)
    {
        $this->logger = $logger;
        $this->errorController = $errorController;
    }

    public function handle(\Exception $e)
    {
        $logger = new FileLogger("/home/user01/workspace/POO.dev/error.log");
        $logger->log(
            sprintf(
                "[%s] - %s",
                date("Y-m-d H:i:s"),
                $e->getMessage()
            )
        );
        $action = "genericErrorAction";

        if($e instanceof RouteNotFound)
        {
            $action = "routeNotFoundAction";
        }

        // callable
        return [$this->errorController, $action];
    }
} 