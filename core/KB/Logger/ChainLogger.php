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
     * @param LoggerInterface $logger
     * @return $this
     */
    public function addLogger(LoggerInterface $logger) {
        $this->loggers[] = $logger;

        return $this;
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return mixed|void
     */
    public function log($level, $message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->emergency($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->alert($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->critical($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->error($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->warning($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->notice($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->info($message, $context);
        }
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        /** @var LoggerInterface $logger */
        foreach ($this->loggers as $logger) {
            $logger->debug($message, $context);
        }
    }
}