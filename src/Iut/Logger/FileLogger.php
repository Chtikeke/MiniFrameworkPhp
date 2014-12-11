<?php

namespace Iut\Logger;

use Iut\FileTools;

class FileLogger implements LoggerInterface
{
    private $filename;

    public function __construct($filename)
    {
        FileTools::createFileIfNotExists($filename);
        $this->filename = $filename;
    }

    public function log($message)
    {
        file_put_contents($this->filename, $message, FILE_APPEND);
    }
} 