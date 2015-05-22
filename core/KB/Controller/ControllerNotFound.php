<?php

namespace KB\Controller;

/**
 * Class ControllerNotFound
 * @package KB\Controller
 */
class ControllerNotFound extends \LogicException
{
    /**
     * @param string $className
     */
    public function __construct($className)
    {
        parent::__construct(sprintf("Controller '%s' doesn't exist.", $className));
    }
}