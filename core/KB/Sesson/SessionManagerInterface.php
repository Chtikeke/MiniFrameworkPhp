<?php

namespace KB\Session;

/**
 * Interface SessionManagerInterface
 */
interface SessionManagerInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * @return mixed
     */
    public function start();

    /**
     * @return mixed
     */
    public function destroy();

    /**
     * @return mixed
     */
    public function clear();
}