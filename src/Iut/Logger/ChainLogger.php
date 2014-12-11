<?php

namespace Iut\Logger;

class ChainLogger implements LoggerInterface
{
    private $loggers;

    public function __construct(array $loggers = [])
    {
        foreach($loggers as $logger)
        {
            $this->addLogger($logger);
        }

        $this->loggers = $loggers;
    }

    public function log($message)
    {
        foreach($this->loggers as $logger)
        {
            $logger->log($message);
        }
    }

    public function warn($message)
    {
        foreach($this->loggers as $logger)
        {
            $logger->warn($message);
        }
    }

    public function addLogger(LoggerInterface $logger)
    {
        $this->loggers[] = $logger;
    }
} 