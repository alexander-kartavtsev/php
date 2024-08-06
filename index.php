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

    $query  = $pdo->prepare('UPDATE users SET `NAME` = :name, `PHOTO` = :photo WHERE `ID` = :id');
    $result = $query->execute([
        'name'  => $name,
        'photo' => $photo,
        'id'    => $user->getId(),
    ]);

    if ($result) {
        header('Location: /');
        die;
    } else {
        $errors["query"] = $query->errorInfo();
    }
}
require $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
?>
<div class="page_content main_page">
    <h1>Страница пользователя <?= $user->getLogin() ?></h1>
    <div class="main_wrapper">
        <div class="form_main">
            <div class="main_data">
                <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <h2>Основные данные</h2>
                    <div class="label"><label for="name">Имя</label></div>
                    <input
                            name="name"
                            type="text"
                            placeholder="Имя пользователя"
                            value="<?= $user->getName() ?: 'noname' ?>"
                    >
                    <div class="label"><label for="password">Пароль</label></div>
                    <input name="password" type="password" placeholder="Введите пароль">
                    <div class="label"><label for="password_confirm">Подтвердите пароль</label></div>
                    <input name="password_confirm" type="password" placeholder="Повторите пароль">
                    <div class="label"><label for="photo">Фото</label></div>
                    <select name="photo">
                        <option value="" <?= $user->isSelectedPhoto() ? '' : 'selected' ?>>Выберите фото</option>
                        <?php
                        if ($user->getPhotoList()) {
                            foreach ($user->getPhotoList() as $photo) { ?>
                                <option value="<?= $photo['name'] ?>" <?= $photo['selected'] ? 'selected' : ''?>>
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
                <table class="tbl">
                    <tr>
                        <td>
                            Телефон
                        </td>
                        <td>
                            +79281252141
                        </td>
                        <td>
                            <span id="additional_data_1" class="additional_data_delete">Удалить</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Дата рождения
                        </td>
                        <td>
                            29.07.1974
                        </td>
                        <td>
                            <span  id="additional_data_2" class="additional_data_delete">Удалить</span>
                        </td>
                    </tr>
                </table>
                <table class="add">
                    <tr>
                        <th>Наименование</th>
                        <th>Значение</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>
                            <input name="field_name" type="text">
                        </td>
                        <td>
                            <input name="field_value" type="text">
                        </td>
                        <td>
                            <button class="additional_data_btn">Добавить</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="main_image">
            <?php
            if ($user->isSelectedPhoto()) { ?>
                <img src="<?=$user->getPhotoSrc()?>">
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
    const fileLink  = document.getElementById('photo_link');

    fileLabel.onclick = function () {
        fileInput.click();
    };

    fileInput.onchange = function () {
        console.log(fileInput.files);
        fileLink.textContent = fileInput.files.length ? fileInput.files[0].name : 'Файл не выбран';
        fileLabel.textContent = (fileInput.files.length ? 'Изменить' : 'Добавить') + ' фото';
    }
</script>
<?php
require $_SERVER['DOCUMENT_ROOT'] . "/layout/footer.php";
?>
