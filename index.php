<?php

const NEED_AUTH = true;
require_once $_SERVER['DOCUMENT_ROOT'] . "/app/init.php";
$user = new CurrentUser();
/**
 * @var PDO $pdo
 */
$errors = [];
if (!empty($_POST)) {
    $name  = $_POST['name'] == 'noname' ? '' : $_POST['name'];
    $photo = $_POST['photo'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    $sql_start = 'UPDATE users SET ';
    $sql_data = '';
    $sql_where = ' WHERE `ID` = :id';
    $query_params = ['id' => $user->getId()];

    if (!empty($name)) {
        $sql_data .= '`NAME` = :name';
        $query_params['name'] = $name;
    }

    if (!empty($photo)) {
        $sql_data .= (!empty($sql_data) ? ', ' : '') . '`PHOTO` = :photo';
        $query_params['photo'] = $photo;
    }

    if (!empty($password)) {
        if (empty($password_confirm)) {
            $errors['password_confirm'] = "Необходимо подтвердить пароль!";
        } elseif ($password_confirm !== $password) {
            $errors['password_confirm'] = "Пароли отличаются!";
        } else {
            $sql_data .= (!empty($sql_data) ? ', ' : '') . '`PASSWORD` = :password';
            $query_params['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    if (empty($errors)) {
        $sql    = $sql_start . $sql_data . $sql_where;
        $query  = $pdo->prepare($sql);
        $result = $query->execute($query_params);

        if ($result) {
            header('Location: /');
            die;
        } else {
            $errors["other"] = $query->errorInfo();
        }
    }
}
$errorClass = function ($fieldName) use ($errors) {
    return isset($errors[$fieldName]) ? ' class="input-error"' : '';
};

require $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
?>
<div class="page_content main_page">
    <h1>Страница пользователя <?= $user->getLogin() ?></h1>
    <div class="main_wrapper">
        <div class="form_main">
            <div class="main_data">
                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <h2>Основные данные</h2>
                    <div class="form-item">
                        <div class="label"><label for="name">Имя</label></div>
                        <input
                                name="name"
                                type="text"
                                placeholder="Имя пользователя"
                                value="<?= $user->getName() ?: 'noname' ?>"
                                autocomplete="username"
                        >
                    </div>
                    <div class="form-item">
                        <div class="label"><label for="password">Пароль</label></div>
                        <input
                                name="password"
                                type="password"
                                placeholder="Введите пароль"
                                value="<?= $password ?? '' ?>"
                                autocomplete="current-password"
                        >
                    </div>
                    <div class="form-item">
                        <div class="label"><label for="password_confirm">Подтвердите пароль</label></div>
                        <input
                                name="password_confirm"
                                type="password"
                                placeholder="Повторите пароль"
                                value="<?= $password_confirm ?? '' ?>"
                                autocomplete="off"
                                <?= $errorClass("password_confirm")?>
                        >
                        <div class="error-message"><?= $errors['password_confirm'] ?? '' ?></div>
                        <div class="error-message"><?= $errors['other'] ?? '' ?></div>
                    </div>
                    <div class="label"><label for="photo">Фото</label></div>
                    <select name="photo">
                        <option value="" <?= $user->isSelectedPhoto() ? '' : 'selected' ?>>Выберите фото</option>
                        <?php
                        if ($user->getPhotoList()) {
                            foreach ($user->getPhotoList() as $photo) { ?>
                                <option value="<?= $photo['name'] ?>" <?= $photo['selected'] ? 'selected' : '' ?>>
                                    <?= $photo['name'] ?>
                                </option>
                                <?php
                            }
                        } ?>
                    </select>
                    <button class="auth_btn" type="submit">Сохранить</button>
                </form>
            </div>
            <div class="additional_data">
                <h2>Дополнительные данные</h2>
                <table class="tbl" id="table_add_data">
                    <?php foreach ($user->getData() as $key => $dataItem) { ?>
                    <tr id="additional_data_row_<?= $key ?>">
                        <td>
                            <?= $dataItem['name']?>
                        </td>
                        <td>
                            <?= $dataItem['value']?>
                        </td>
                        <td>
                            <span id="delete_<?= $key ?>" class="additional_data_delete">Удалить</span>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <table class="add">
                    <tr>
                        <th>Наименование</th>
                        <th>Значение</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            <input name="field_name" type="text" id="add_field_name">
                        </td>
                        <td>
                            <input name="field_value" type="text" id="add_field_value">
                        </td>
                        <td>
                            <button class="additional_data_btn" id="add_btn">Добавить</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="main_image">
            <?php
            if ($user->isSelectedPhoto()) { ?>
                <img src="<?= $user->getPhotoSrc() ?>">
                <?php
            } else { ?>
                <img src="images/person14-1024.png">
                <!--                    <img src="images/not_foto.png">-->
                <?php
            } ?>
            <form method="post" action="<?= '/app/helper/uploadPhoto.php' ?>" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $user->getId() ?>">
                <div class="label">
                    <label
                            for="photo"
                            class="custom_photo_upload"
                            id="custom_photo_upload"
                    >
                        Загрузить фото
                    </label>
                </div>
                <input name="photo" type="file" class="photo_upload" id="photo_upload">
                <span class="photo_link" id="photo_link">Файл не выбран</span>
                <button type="submit" class="photo_upload_btn btn">Загрузить</button>
            </form>
        </div>
    </div>
</div>
<script>
    const fileInput = document.getElementById('photo_upload');
    const fileLabel = document.getElementById('custom_photo_upload');
    const fileLink = document.getElementById('photo_link');

    fileLabel.onclick = function () {
        fileInput.click();
    };

    fileInput.onchange = function () {
        fileLink.textContent = fileInput.files.length ? fileInput.files[0].name : 'Файл не выбран';
        fileLabel.textContent = (fileInput.files.length ? 'Изменить' : 'Добавить') + ' фото';
    }

    const additionalDataName = document.getElementById("add_field_name");
    const additionalDataValue = document.getElementById("add_field_value");
    const additionalDataButtonAdd = document.getElementById("add_btn");
    const tableAddData = document.getElementById("table_add_data");

    additionalDataButtonAdd.onclick = function () {
        const data = {
            'name': additionalDataName.value,
            'value': additionalDataValue.value,
            'user_id': <?=$user->getId()?>
        };
        ajax('/app/ajax/addAdditionalData.php', data, function (result) {
            tableAddData.appendChild(getTableRow(result.data.length - 1, data['name'], data['value']));
            additionalDataName.value = '';
            additionalDataValue.value = '';
        });
    }

    tableAddData.onclick = function (event) {
        let btn_del = event.target.closest('td>span.additional_data_delete');
        if (!btn_del) return;
        if (!tableAddData.contains(btn_del)) return;

        const btn_id = event.target.id;
        const id = btn_id.substring(btn_id.indexOf('_') + 1);
        const data = {
            'id': id,
            'user_id': <?=$user->getId()?>
        };
        ajax('/app/ajax/delAdditionalData.php', data, function (result) {
            const row = document.getElementById('additional_data_row_' + id);
            row.remove();
        });
    }

    async function ajax(url, data, fn = null) {
        let response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=UTF-8'
            },
            body: JSON.stringify(data)
        });

        let result = await response.json();
        if (result.success && fn) {
            fn(result);
        }
    }

    function getTableRow(id, name, value) {
        const tableRow = document.createElement('tr');
        tableRow.id = 'additional_data_row_' + id;
        const tableColumnOne = document.createElement('td');
        const tableColumnTwo = document.createElement('td');
        const tableColumnThree = document.createElement('td');
        tableColumnOne.innerText = name;
        tableRow.appendChild(tableColumnOne);
        tableColumnTwo.innerText = value;
        tableRow.appendChild(tableColumnTwo);
        const span = document.createElement('span');
        span.classList.add('additional_data_delete');
        span.id = 'delete_' + id;
        span.innerText = 'Удалить';
        tableColumnThree.appendChild(span);
        tableRow.appendChild(tableColumnThree);

        return tableRow;
    }
</script>
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php";
?>
