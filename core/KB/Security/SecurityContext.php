<?php

namespace KB\Security;

use KB\Session\SessionManagerInterface;

class SecurityContext
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var string
     */
    private $userClassName;

    /**
     * @param SessionManagerInterface $sessionManager
     * @param $userClassName
     */
    public function __construct(SessionManagerInterface $sessionManager, $userClassName)
    {
        $this->sessionManager = $sessionManager;
        $this->userClassName = $userClassName;

        $this->sessionManager->start();
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->sessionManager->get('user');
    }

    /**
     * @return mixed
     */
    public function isAuthenticated()
    {
        return $this->sessionManager->get('authenticated');
    }

    /**
     * @param $user
     * @param bool $isAuthenticated
     * @return $this
     */
    public function save($user, $isAuthenticated = true)
    {
        $this->sessionManager->set('user', $user);
        $this->sessionManager->set('authenticated', $isAuthenticated);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->sessionManager->clear();
        $this->sessionManager->destroy();

        return $this;
    }

    /**
     * @return SessionManagerInterface
     */
    public function getSessionManager()
    {
        return $this->sessionManager;
    }
}