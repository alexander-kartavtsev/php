<?php
/**
 *@var Pagination $this
 */
?>
<div class="pagen">
    <?php //Кнопка со стрелками влево ?>
    <?php if ($this->getPageCount() > 1) { ?>
        <div>
            <?php if (!$this->isFirstPage()) { ?>
                <a href="<?= $this->getPrevPageLink() ?>">
            <?php } ?>
                <div class="pagen_box<?= $this->isFirstPage() ? ' pagen_box_current' : ''?>">
                    <<
                </div>
            <?php if (!$this->isFirstPage()) { ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
    <?php for ($page = $this->getFirstShow(); $page <= $this->getLastShow(); $page++) { ?>
        <div>
            <?php if (!$this->isCurrentPage($page)) { ?>
                <a href="<?= $this->getPageLink($page)?>">
            <?php } ?>
                <div class="pagen_box<?= $this->isCurrentPage($page) ? ' pagen_box_current' : ''?>">
                    <?= $page ?>
                </div>
            <?php if (!$this->isCurrentPage($page)) { ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
    <?php //Кнопка со стрелками вправо ?>
    <?php if ($this->getPageCount() > 1) { ?>
        <div>
            <?php if (!$this->isLastPage()) { ?>
                <a href="<?= $this->getNextPageLink() ?>">
            <?php } ?>
                <div class="pagen_box<?= $this->isLastPage() ? ' pagen_box_current' : ''?>">
                    >>
                </div>
            <?php if (!$this->isLastPage()) { ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
