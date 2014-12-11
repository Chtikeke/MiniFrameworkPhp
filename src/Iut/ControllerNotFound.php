<?php

namespace Iut;

class ControllerNotFound extends \LogicException
{
    public function __construct($className)
    {
        parent::__construct(
            sprintf(
                "Le controleur '%s' n'existe pas.",
                $className
            )
        );
    }
}