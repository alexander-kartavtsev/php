<?php

/**
 * @var string $orderBy
 * @var string $orderTo
 */
$arBy = [
    ['value' => 'id', 'name' => '-'],
    ['value' => 'login', 'name' => 'Логин'],
    ['value' => 'name', 'name' => 'Имя'],
    ['value' => 'visits', 'name' => 'Визиты'],
    ['value' => 'number', 'name' => 'Число'],
];

$arTo = [
    ['value' => 'asc', 'name' => 'По возрастанию'],
    ['value' => 'desc', 'name' => 'По убыванию'],
];
?>
<div class="sort">
    <div class="sort_box">
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
    <div class="sort_box">
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

    sortBy.onclick = sortBy.onchange = function () {
        window.location.replace(getQueryString('by', this.value));
    }

    sortTo.onclick = sortTo.onchange = function () {
        window.location.replace(getQueryString('to', this.value));
    }

    function getQueryString(key, value) {
        let queryString = '<?=$_SERVER['QUERY_STRING']?>';
        const arQueryString = queryString.split('&');
        let arQuery = {};
        for (let i = 0; i < arQueryString.length; i++) {
            const arQueryItem = arQueryString[i].split('=');
            if (arQueryItem[0].length && arQueryItem[1].length) {
                arQuery[arQueryItem[0]] = arQueryItem[1];
            }
        }
        arQuery[key] = value;
        queryString = '';
        for (let key in arQuery) {
            const queryItem = key + '=' + arQuery[key];
            queryString += queryString.length === 0 ? queryItem : '&' + queryItem;
        }
        return '?' + queryString;
    }
</script>