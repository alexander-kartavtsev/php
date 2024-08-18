<?php

const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
/** @var User $user */
$current = (int)($_GET['pagen'] ?? 1);
$orderBy = (string)($_GET['by'] ?? 'id');
$orderTo = (string)($_GET['to'] ?? 'asc');
$usersObj = new Users();
$users = $usersObj
    ->setCountOnPage(5)
    ->setPagen($current)
    ->setOrderBy($orderBy)
    ->setOrderDesc($orderTo === 'desc')
    ->getUsers();
$pagen = new Pagination($usersObj->getPageCount(), $current, $_SERVER['REQUEST_URI']);
?>
    <div class="page_content users_page">
        <h1>Данные пользователей</h1>
        <?php $pagen->show();?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/sort.php'?>
        <table class="users_data">
            <tr>
                <th class="login">login</th>
                <th class="name">Имя пользователя</th>
                <th class="number">Количество посещений</th>
                <th class="number">Число</th>
            </tr>
            <?php
            foreach ($users as $user) { ?>
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
