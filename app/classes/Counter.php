<?php

class Counter
{
    private CurrentUser $user;
    private int         $visits;
    private int         $number;

    public function __construct()
    {
        $this->user = new CurrentUser();
        $this->init();
    }

    public function getVisits(): int
    {
        return $this->visits;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    private function init(): void
    {
        global $pdo;

        $sql = 'SELECT `VISITS` AS `visits`, `NUMBER` AS `number` FROM counters WHERE `USER_ID` = :id';

        $query = $pdo->prepare($sql);
        $query->execute(['id' => $this->user->getId()]);
        $counter = $query->fetchObject();

        $this->visits = $counter->visits ?? 0;
        $this->number = $counter->number ?? 0;
    }
}