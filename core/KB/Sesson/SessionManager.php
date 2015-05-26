<?php

namespace KB\Session;

/**
 * Class SessionManager
 */
class SessionManager implements SessionManagerInterface
{
    /**
     * @var bool
     */
    private $sessionStarted = false;

    /**
     * @param $key
     * @return mixed|null
     * @throws \Exception
     */
    public function get($key)
    {
        if ($this->sessionStarted) {
            return $_SESSION[$key] ?: false;
        }

        throw new \Exception('Session not started yet');
    }

    /**
     * @param $key
     * @param $value
     * @return mixed|null
     * @throws \Exception
     */
    public function set($key, $value)
    {
        if ($this->sessionStarted) {
            $_SESSION[$key] = $value;
            return $this;
        }

        throw new \Exception('Session not started yet');
    }

    /**
     * @return mixed
     */
    public function start()
    {
        return $this->sessionStarted = session_start();
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
        return session_destroy();
    }

    /**
     * @return void
     */
    public function clear()
    {
        session_unset();
    }
}