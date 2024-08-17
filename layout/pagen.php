<?php
$pageUrl = $_SERVER['DOCUMENT_URI'];
$current = (int)($_GET['pagen'] ?? 1);
$max = 3;
$maxShow = 5;
$diff = round($maxShow / 2, 0, PHP_ROUND_HALF_DOWN);
$showFirst = $current > $diff && $max > $maxShow ? (int)($current - $diff) : 1;
if ($max > $maxShow) {
    $showFirst = (int)min($showFirst, $max - ($maxShow - 1));
}
$showLast = $current <= $max - $diff? min($showFirst + $maxShow - 1, $max) : $max;
$next = $current < $max ? $current + 1 : $current;
$prev = $current > 1 ? $current - 1 : 1;
$isFirst = $current === 1;
$isLast = $current === $max;
//dump([
//        'uri' => $_SERVER['DOCUMENT_URI'],
//    'maxShow' => $maxShow,
//    'showFirst' => $showFirst,
//    'showLast' => $showLast,
//    'diff' => $diff,
//    'max'     => $max,
//    'current' => $current,
//    'next'    => $next,
//    'prev'    => $prev,
//    'isFirst' => $isFirst,
//    'isLast'  => $isLast,
//]);
?>
<form method="get">
    <div class="pagen">
        <?php
        //Кнопка со стрелками влево ?>
        <?php
        if ($max > 1) { ?>
            <div>
                <?php
                if (!$isFirst) { ?>
                <a href="<?= $prev > 1 ? '?pagen=' . $prev : $pageUrl ?>">
                    <?php
                    } ?>
                    <div class="pagen_box<?= $isFirst ? ' pagen_box_current' : ''?>"><<</div>
                    <?php
                    if (!$isFirst) { ?>
                </a>
            <?php
            } ?>
            </div>
        <?php
        } ?>
        <?php for ($page = $showFirst; $page <= $showLast; $page++) { ?>
        <div>
            <?php if ((int)$page !== $current) { ?>
            <a href="<?= $page > 1 ? '?pagen=' . $page : $pageUrl?>">
                <?php } ?>
            <div class="pagen_box<?=$page === $current ? ' pagen_box_current' : ''?>"><?= $page ?></div>
                <?php if ($page !== $current) { ?>
                </a>
                    <?php } ?>
        </div>
        <?php } ?>
        <?php
        //Кнопка со стрелками вправо ?>
        <?php
        if ($max > 1) { ?>
            <div>
                <?php
                if (!$isLast) { ?>
                <a href="?pagen=<?= $next ?>">
                    <?php
                    } ?>
                    <div class="pagen_box<?= $isLast ? ' pagen_box_current' : ''?>">>></div>
                    <?php
                    if (!$isLast) { ?>
                </a>
            <?php
            } ?>
            </div>
            <?php
        } ?>
    </div>
</form>
