<?php

namespace KB\Logger;

/**
 * Class ChainLogger
 */
class ChainLogger implements LoggerInterface
{
    /**
     * @var array
     */
    private $loggers;

    /**
     * @param array $loggers
     */
    public function __construct(array $loggers = [])
    {
        foreach ($loggers as $logger) {
            $this->addLogger($logger);
        }

        $this->loggers = $loggers;
    }

    /**
     * @param $message
     * @return mixed|void
     */
    public function log($message)
    {
        foreach ($this->loggers as $logger) {
            $logger->log($message);
        }
    }

    /**
     * @param $message
     */
    public function warn($message)
    {
        foreach($this->loggers as $logger) {
            $logger->warn($message);
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function addLogger(LoggerInterface $logger) {
        $this->loggers[] = $logger;
    }
} 