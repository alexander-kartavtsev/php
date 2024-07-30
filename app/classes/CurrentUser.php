<?php

class CurrentUser
{
    private int    $id;
    private string $login;
    private string $name;

    public function __construct()
    {
        $this->init();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function init(): void
    {
        global $pdo;

        $sql = <<<SQL
SELECT `ID` AS `id`, 
       `NAME` AS `name`, 
       `LOGIN` AS `login`
FROM users WHERE `ID` = :id
SQL;

        $query = $pdo->prepare($sql);
        $query->execute(['id' => getUserIdByToken() ?? 0]);
        $user = $query->fetchObject();

        $this->id    = $user->id;
        $this->login = $user->login;
        $this->name  = (string)$user->name;
    }
}