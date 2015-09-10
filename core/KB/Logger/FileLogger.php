<?php

namespace KB\Logger;

use KB\File\FileTools;

/**
 * Class FileLogger
 */
class FileLogger implements LoggerInterface
{
    /**
     * @var
     */
    private $filename;

    /**
     * @param $filename
     */
    public function __construct($filename)
    {
        FileTools::createFileIfNotExists($filename);
        $this->filename = $filename;
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @throws \Exception
     * @return mixed|void
     */
    public function log($level, $message, array $context = array())
    {
        if (
            in_array(
                $level,
                array(
                    LogLevel::DEBUG,
                    LogLevel::NOTICE,
                    LogLevel::INFO,
                    LogLevel::WARNING,
                    LogLevel::ERROR,
                    LogLevel::ALERT,
                    LogLevel::CRITICAL,
                    LogLevel::EMERGENCY
                )
            )
        ) {
            file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper($level) . '] ' . $message) . PHP_EOL, FILE_APPEND);
        } else {
            throw new \Exception(sprintf('Log level %s does not exist', $level));
        }

    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::EMERGENCY) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::ALERT) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::CRITICAL) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::ERROR) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::WARNING) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::NOTICE) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::INFO) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }

    /**
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        file_put_contents($this->filename, sprintf("[%s] - %s", date("Y-m-d H:i:s"), '[' . strtoupper(LogLevel::DEBUG) . '] ' . $message) . PHP_EOL, FILE_APPEND);
    }
}
