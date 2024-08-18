<?php

/**
 * @var Sort $this
 */
?>
<div class="sort">
    <div class="sort_box">
        Сортировка:
    </div>
    <div class="sort_box by">
        <select class="sort_box_select" id="sort_by">
            <?php foreach ($this->arOrderBy as $by) { ?>
                <option
                    value="<?= $by['value'] ?>"
                    <?= $this->orderBy === $by['value'] ? ' selected' : '' ?>
                >
                    <?= $by['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="sort_box to">
        <select class="sort_box_select" id="sort_to">
            <?php foreach ($this->arOrderTo as $to) { ?>
                <option
                    value="<?= $to['value'] ?>"
                    <?= $this->orderTo === $to['value'] ? ' selected' : '' ?>
                >
                    <?= $to['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>