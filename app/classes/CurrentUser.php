<?php

class CurrentUser
{
    private int    $id;
    private string $login;
    private string $name;
    private array  $data;
    private string $photo;
    private bool   $isSelectedPhoto = false;

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

    public function getData(): array
    {
        return $this->data;
    }

    public function getPhotoSrc(): string
    {
        return '/images/users/' . $this->id . '/' . $this->photo;
    }

    public function isSelectedPhoto(): bool
    {
        return $this->isSelectedPhoto;
    }

    public function getPhotoList(): array
    {
        $list = [];
        $dir  = $_SERVER['DOCUMENT_ROOT'] . '/images/users/' . $this->id . '/';
        if (!is_dir($dir)) {
            umask(0);
            mkdir($dir, 0777, true);
        }
        $files = scandir($dir);
        if (!$files) {
            return [];
        }
        foreach ($files as $key => $item) {
            if (in_array($item, ['.', '..'])) {
                unset($files[$key]);
                continue;
            }
            if ($item === $this->photo) {
                $this->isSelectedPhoto = true;
            }
            $list[] = [
                'name'     => $item,
                'selected' => $item === $this->photo,
            ];
        }
        return $list;
    }

    private function init(): void
    {
        global $pdo;

        $sql = <<<SQL
SELECT `ID` AS `id`, 
       `NAME` AS `name`, 
       `DATA` AS `data`, 
       `LOGIN` AS `login`,
       `PHOTO` AS `photo`
FROM users WHERE `ID` = :id
SQL;

        $query = $pdo->prepare($sql);
        $query->execute(['id' => getUserIdByToken() ?? 0]);
        $user = $query->fetchObject();

        $this->id    = $user->id;
        $this->login = $user->login;
        $this->name  = (string)$user->name ?: "noname";
        $this->data  = json_decode($user->data ?? '[]', true);
        $this->photo = (string)$user->photo;
    }
}