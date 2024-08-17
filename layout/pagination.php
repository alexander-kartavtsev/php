<?php
/**
 *@var Pagination $this
 */
?>
<form method="get">
    <div class="pagen">
        <?php
        //Кнопка со стрелками влево ?>
        <?php
        if ($this->getPageCount() > 1) { ?>
            <div>
                <?php
                if (!$this->isFirstPage()) { ?>
                <a href="<?= $this->getPrevPage() > 1 ? '?pagen=' . $this->getPrevPage() : $this->getPageUrl() ?>">
                    <?php
                    } ?>
                    <div class="pagen_box<?= $this->isFirstPage() ? ' pagen_box_current' : ''?>"><<</div>
                    <?php
                    if (!$this->isFirstPage()) { ?>
                </a>
            <?php
            } ?>
            </div>
        <?php
        } ?>
        <?php for ($page = $this->getFirstShow(); $page <= $this->getLastShow(); $page++) { ?>
        <div>
            <?php if (!$this->isCurrentPage($page)) { ?>
            <a href="<?= $page > 1 ? '?pagen=' . $page : $this->getPageUrl()?>">
                <?php } ?>
            <div class="pagen_box<?= $this->isCurrentPage($page) ? ' pagen_box_current' : ''?>"><?= $page ?></div>
                <?php if (!$this->isCurrentPage($page)) { ?>
                </a>
                    <?php } ?>
        </div>
        <?php } ?>
        <?php
        //Кнопка со стрелками вправо ?>
        <?php
        if ($this->getPageCount() > 1) { ?>
            <div>
                <?php
                if (!$this->isLastPage()) { ?>
                <a href="?pagen=<?= $this->getNextPage() ?>">
                    <?php
                    } ?>
                    <div class="pagen_box<?= $this->isLastPage() ? ' pagen_box_current' : ''?>">>></div>
                    <?php
                    if (!$this->isLastPage()) { ?>
                </a>
            <?php
            } ?>
            </div>
            <?php
        } ?>
    </div>
</form>
