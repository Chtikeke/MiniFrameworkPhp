<?php

namespace KB\Logger;

/**
 * Interface LoggerInterface
 */
interface LoggerInterface
{
    /**
     * @param $message
     * @return mixed
     */
    public function log($message);
}