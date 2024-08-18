<?php

class Page
{
    private array $scripts = [];

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
}