<?php

namespace KB\Http;

/**
 * Class Header
 */
class Header
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->checkName($name);
        $this->checkValue($value, $name);
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: %s', $this->name, $this->value);
    }

    /**
     * @param $name
     */
    private function checkName($name)
    {
        if (!preg_match('/^[a-z-]{1,128}$/i', $name)) {
            throw InvalidHeaderException::name($name);
        }
    }

    /**
     * @param $value
     * @param $name
     */
    private function checkValue($value, $name)
    {
        if (!preg_match('/^.*$/', $value)) {
            throw InvalidHeaderException::value($value, $name);
        }
    }
} 