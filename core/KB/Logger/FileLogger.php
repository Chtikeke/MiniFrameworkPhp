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
     * @param $message
     * @return mixed|void
     */
    public function log($message)
    {
        file_put_contents($this->filename, $message, FILE_APPEND);
    }
} 