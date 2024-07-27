<?php
const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
?>
    <div class="page_content users_page">
      <h1>Данные пользователей</h1>
      <table class="users_data">
        <tr>
          <th>login</th>
          <th>Имя</th>
          <th>Количество посещений</th>
          <th>Число</th>
        </tr>
        <tr class="current">
          <td class="login">login</td>
          <td class="name">Александр</td>
          <td class="visits_count">24</td>
          <td class="simple_number">15</td>
        </tr>
        <tr>
          <td class="login">user12345</td>
          <td class="name">Михаил</td>
          <td class="visits_count">12</td>
          <td class="simple_number">548</td>
        </tr>
        <tr>
          <td class="login">maxim</td>
          <td class="name">Максим</td>
          <td class="visits_count">0</td>
          <td class="simple_number">0</td>
        </tr>
      </table>

    </div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
