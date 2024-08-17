<?php

const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
/** @var User $user */
$current = (int)($_GET['pagen'] ?? 1);
$max = 3;
$pagen = new Pagination($max, $current, $_SERVER['DOCUMENT_URI']);
?>
    <div class="page_content users_page">
        <h1>Данные пользователей</h1>
        <?php $pagen->show();?>
        <table class="users_data">
            <tr>
                <th class="login">login</th>
                <th class="name">Имя пользователя</th>
                <th class="number">Количество посещений</th>
                <th class="number">Число</th>
            </tr>
            <?php
            foreach (Users::getAll() as $user) { ?>
                <tr<?= $user->current ? ' class="current"' : '' ?>>
                    <td class="login"><?= $user->getLogin() ?></td>
                    <td class="name"><?= $user->getName() ?></td>
                    <td class="visits_count"><?= $user->getVisits() ?></td>
                    <td class="simple_number"><?= $user->getNumber() ?></td>
                </tr>
            <?php
            } ?>
        </table>
        <?php $pagen->show();?>
    </div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
