<?php

namespace Iut\Http;

class Header
{
    private $name, $value;

    // En ayant cet ordre, il n'y aura jamais d'en-tête invalide. Sécurisation de l'objet
    public function __construct($name, $value)
    {
        $this->checkName($name);
        $this->checkValue($value, $name);
        $this->name = $name;
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return sprintf('%s: %s', $this->name, $this->value);
    }

    private function checkName($name)
    {
        if(!preg_match('/^[a-z-]{1,128}$/i', $name))
        {
            throw InvalidHeaderException::name($name);
        }
    }

    private function checkValue($value, $name)
    {
        if(!preg_match('/^.*$/', $value))
        {
            throw InvalidHeaderException::value($value, $name);
        }
    }
} 