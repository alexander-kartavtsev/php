<?php

class Sort
{
    private array $arOrderBy = [];
    private array $arOrderTo = [];
    private string $orderBy = 'id';
    private string $orderTo = 'asc';

    public function __construct(
        private readonly string $page
    ) {
        $this->init();
    }

    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setOrderTo(string $orderTo): self
    {
        $this->orderTo = $orderTo;
        return $this;
    }

    public function getScript(): string
    {
        return '/js/sort.js';
    }

    public function show(): void
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/layout/sort.php';
    }

    private function init(): void
    {
        $this->initArOrderBy();
        $this->initArOrderTo();
    }

    private function initArOrderBy(): void
    {
        $fileName = $_SERVER['DOCUMENT_ROOT'] . "/sort/$this->page/orderBy.php";
        if (file_exists($fileName)) {
            $this->arOrderBy = require $fileName;
        }
    }

    private function initArOrderTo(): void
    {
        $this->arOrderTo = require $_SERVER['DOCUMENT_ROOT'] . '/sort/orderTo.php';
    }
}