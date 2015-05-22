<?php

namespace KB\Http;

/**
 * Class InvalidHeaderException
 */
class InvalidHeaderException extends \InvalidArgumentException
{
    /**
     * @param $name
     * @return InvalidHeaderException
     */
    static public function name($name)
    {
        return new self(sprintf(
            "Le nom de l'en-tête est invalide : '%s'", $name
        ));
    }

    /**
     * @param $value
     * @param $name
     * @return InvalidHeaderException
     */
    static public function value($value, $name)
    {
        return new self(sprintf(
           "La valeur de l'en-tête '%s' est invalide : '%s'",
           $name,
           $value
        ));
    }
} 