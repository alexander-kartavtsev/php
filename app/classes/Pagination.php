<?php

class Pagination
{
    private const COUNT_SHOW = 5;

    private int $diff;
    private int $firstShow;
    private int $lastShow;
    private ?int $nextPage = null;
    private ?int $prevPage = null;
    private string $pageUrl;
    private array $query = [];

    public function __construct(
        private readonly int $pageCount,
        private int $currentPage,
        private readonly string $url
    ) {
        $this->init();
        $this->initPageUrl();
    }

    public function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    public function isLastPage(): bool
    {
        return $this->currentPage === $this->pageCount;
    }

    public function getPageUrl(): string
    {
        unset($this->query['pagen']);
        return $this->pageUrl . $this->getQueryString();
    }

    public function getFirstShow(): int
    {
        return $this->firstShow;
    }

    public function getLastShow(): int
    {
        return $this->lastShow;
    }

    public function getNextPage(): int
    {
        return $this->nextPage;
    }

    public function getPrevPage(): int
    {
        return $this->prevPage;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function isCurrentPage(int $page): bool
    {
        return $page === $this->currentPage;
    }

    public function show(): void
    {
        if ($this->isValid()) {
            include $_SERVER['DOCUMENT_ROOT'] . '/layout/pagination.php';
        }
    }

    public function getPrevPageLink(): string
    {
        $link = $this->prevPage > 1 ? $this->genLink($this->prevPage) : $this->getPageUrl();
        return $link;
    }

    public function getNextPageLink(): string
    {
        return $this->genLink($this->nextPage);
    }

    public function getPageLink(int $page): string
    {
        $link = $page > 1 ? $this->genLink($page) : $this->getPageUrl();
        return $link;
    }

    private function genLink(int $page)
    {
        $this->query['pagen'] = $page;
        return $this->getQueryString();
    }

    private function isValid(): bool
    {
        $isValid = true;

        if ($this->currentPage > $this->pageCount) {
            $this->currentPage = $this->pageCount;
        }

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }

        if ($this->pageCount <= 1) {
            $isValid = false;
        }

        $this->init();

        return $isValid;
    }

    private function init(): void
    {
        $this->initDiff();
        $this->initFirstShow();
        $this->initLastShow();
        $this->initNextPage();
        $this->initPrevPage();
    }

    private function initDiff(): void
    {
        $this->diff = round(self::COUNT_SHOW / 2, 0, PHP_ROUND_HALF_DOWN);
    }

    private function initFirstShow(): void
    {
        $this->firstShow = 1;

        if ($this->currentPage > $this->diff && $this->pageCount > self::COUNT_SHOW) {
            $this->firstShow = $this->currentPage - $this->diff;
        }

        if ($this->pageCount > self::COUNT_SHOW) {
            $this->firstShow = (int)min($this->firstShow, $this->pageCount - (self::COUNT_SHOW - 1));
        }
    }

    private function initLastShow(): void
    {
        $this->lastShow = $this->pageCount;
        if ($this->currentPage <= $this->pageCount - $this->diff) {
            $this->lastShow = min(
                $this->firstShow + self::COUNT_SHOW - 1,
                $this->pageCount
            );
        }
    }

    private function initNextPage(): void
    {
        if ($this->currentPage < $this->pageCount) {
            $this->nextPage = $this->currentPage + 1;
        }
    }

    private function initPrevPage(): void
    {
        if ($this->currentPage > 1) {
            $this->prevPage = $this->currentPage - 1;
        }
    }

    private function initPageUrl(): void
    {
        $arUrl = parse_url($this->url);
        $this->pageUrl = $arUrl['path'];
        $queryString = $arUrl['query'] ?? '';
        parse_str($queryString, $this->query);
        unset($this->query['pagen']);
    }

    private function getQueryString()
    {
        return !empty($this->query) ? '?' . http_build_query($this->query) : '';
    }
}