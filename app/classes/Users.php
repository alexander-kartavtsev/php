<?php

class Users
{
    private int    $pagen         = 1;
    private int    $count         = 10;
    private int    $offset        = 0;
    private int    $allUsersCount = 0;
    private string $orderBy       = 'id';
    private string $orderTo       = 'asc';

    public function __construct()
    {
        $this->setOffset();
        $this->setAllUsersCount();
    }

    public function setPagen(int $pagen): self
    {
        $this->pagen = $pagen;
        $this->setOffset();
        return $this;
    }

    public function setCountOnPage(int $count): self
    {
        $this->count = $count;
        $this->setOffset();
        return $this;
    }

    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setOrderDesc(bool $needSet = false): self
    {
        if ($needSet) {
            $this->orderTo = 'desc';
        }
        return $this;
    }

    public function getPageCount(): int
    {
        $remains   = $this->allUsersCount % $this->count;
        $fullPages = ($this->allUsersCount - $remains) / $this->count;
        if ($remains > 0) {
            $fullPages++;
        }
        return $fullPages;
    }

    public function getUsers(): array
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

        $sql .= " ORDER BY $this->orderBy $this->orderTo LIMIT :limit OFFSET :offset";
        $query = $pdo->prepare($sql);
        $query->bindValue('limit', $this->count, PDO::PARAM_INT);
        $query->bindValue('offset', $this->offset, PDO::PARAM_INT);
        $query->execute();
        $arUsers = $query->fetchAll();

        $currentId = getUserIdByToken();

        $users = [];
        foreach ($arUsers as $user) {
            $user['current'] = $user['id'] == $currentId;

            $users[] = User::createFromArray($user);
        }

        return $users;
    }

    private function setOffset(): void
    {
        $this->offset = (int)(($this->pagen - 1) * $this->count);
    }

    private function setAllUsersCount()
    {
        global $pdo;

        $sql = 'SELECT COUNT(*) as CNT FROM users';

        $query = $pdo->prepare($sql);
        $query->execute();
        $this->allUsersCount = $query->fetch()['CNT'];
    }
}