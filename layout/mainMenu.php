<?php
/**
 *@var Page $this
 */
?>
<ul class="main_menu">
    <?php foreach ($this->getMainMenu() as $menuItem) { ?>
        <li>
            <?php if ($this->currentUri !== $menuItem['uri']) { ?>
                <a href="<?= $menuItem['uri'] ?>">
            <?php }
            echo $menuItem['title'];
            if ($this->currentUri !== $menuItem['uri']) { ?>
                </a>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
