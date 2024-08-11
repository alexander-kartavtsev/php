<?php

class Users
{
    public static function getAll()
    {
        global $pdo;

        $sql = <<<SQL
SELECT 
    u.ID as id,
    u.LOGIN as login,
    u.NAME as name,
    c.VISITS as visits,
    c.NUMBER as number
FROM users u LEFT JOIN counters c 
ON u.ID = c.USER_ID
SQL;

        $query = $pdo->prepare($sql);
        $query->execute();
        $arUsers = $query->fetchAll();

        $currentId = getUserIdByToken();

        $users = [];
        foreach ($arUsers as $user) {
            $user['current'] = $user['id'] == $currentId;
            $users[] = User::createFromArray($user);
        }

        usort($users, fn($a, $b) => $b->current <=> $a->current);
        return $users;
    }
}