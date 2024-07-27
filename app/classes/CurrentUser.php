<?php

class CurrentUser
{
    public int $id;

    public function __construct()
    {
        $this->id = getUserIdByToken() ?? 0;
    }
}