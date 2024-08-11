<?php

class User
{
    public string $login  = '';
    public string $name   = '';
    public ?int    $visits = 0;
    public ?int    $number = 0;
    public bool $current = false;

    public static function createFromArray(array $data): self
    {
        $user = new self();

        foreach ($data as $key => $value) {
            if (property_exists($user, $key)) {
                $user->$key = $value;
            }
        }

        return $user;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumber(): int
    {
        return $this->number ?? 0;
    }

    public function getVisits(): int
    {
        return $this->visits ?? 0;
    }
}