<?php

/**
 * @var string $orderBy
 * @var string $orderTo
 */
$arBy = [
    ['value' => 'id', 'name' => 'По-умолчанию'],
    ['value' => 'login', 'name' => 'По логину'],
    ['value' => 'name', 'name' => 'По имени'],
    ['value' => 'visits', 'name' => 'По визитам'],
    ['value' => 'number', 'name' => 'По числу'],
];

$arTo = [
    ['value' => 'asc', 'name' => 'По возрастанию'],
    ['value' => 'desc', 'name' => 'По убыванию'],
];
?>
<div class="sort">
    <div class="sort_box">
        Сортировка:
    </div>
    <div class="sort_box by">
        <select class="sort_box_select" id="sort_by">
            <?php foreach ($arBy as $by) { ?>
                <option
                    value="<?= $by['value'] ?>"
                    <?= $orderBy === $by['value'] ? ' selected' : '' ?>
                >
                    <?= $by['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <div class="sort_box to">
        <select class="sort_box_select" id="sort_to">
            <?php foreach ($arTo as $to) { ?>
                <option
                    value="<?= $to['value'] ?>"
                    <?= $orderTo === $to['value'] ? ' selected' : '' ?>
                >
                    <?= $to['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>
<script>
    const sortBy = document.getElementById('sort_by');
    const sortTo = document.getElementById('sort_to');

    sortBy.onchange = function () {
        window.location.replace(getQueryString('by', this.value));
    }

    sortTo.onchange = function () {
        window.location.replace(getQueryString('to', this.value));
    }

    function getQueryString(key, value) {
        const params = new URLSearchParams(document.location.search);
        params.set(key, value);
        return '?' + params.toString();
    }
</script>