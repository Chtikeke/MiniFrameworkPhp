<?php

namespace Iut\Http;

class InvalidHeaderException extends \InvalidArgumentException
{
    static public function name($name)
    {
        return new self(sprintf(
            "Le nom de l'en-tête est invalide : '%s'", $name
        ));
    }

    static public function value($value, $name)
    {
        return new self(sprintf(
           "La valeur de l'en-tête '%s' est invalide : '%s'",
           $name,
           $value
        ));
    }
} 