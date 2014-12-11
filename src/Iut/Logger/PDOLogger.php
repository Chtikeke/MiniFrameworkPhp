<?php

namespace Iut\Logger;

class PDOLogger implements LoggerInterface
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function log($message)
    {
        $insertQuery = "INSERT INTO 'logger' ('id', 'message', 'logged_on') VALUES (NULL, :message, NOW());";
        $stmt = $this->pdo
            ->prepare($insertQuery);
        $stmt->execute(['message' => $message]);
    }
}