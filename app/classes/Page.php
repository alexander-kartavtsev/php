<?php

class Page
{
    private array $scripts = [];
    private array $mainMenu = [];
    private string $title = '';

    public function __construct(private readonly string $currentUri)
    {
       $this->init();
    }

    public function addPageScript(string $scriptPath): void
    {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $scriptPath)) {
            $this->scripts[] = $scriptPath;
        }
    }

    public function getScripts(): void
    {
        foreach ($this->scripts as $script) {
            echo "<script src=$script></script>";
        }
    }

    public function getMainMenu(): array
    {
        return $this->mainMenu;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function showMainMenu(): void
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/layout/mainMenu.php';
    }

    private function init(): void
    {
        $this->initMainMenu();
        $this->initTitle();
    }

    private function initMainMenu(): void
    {
        $menuPath = $_SERVER['DOCUMENT_ROOT'] . '/menu/main.php';
        if (file_exists($menuPath)) {
            $this->mainMenu = include $menuPath;
        }
    }

    private function initTitle(): void
    {
        $this->title = $this->getMainMenu()[$this->currentUri]['title'] ?? '';
    }
}