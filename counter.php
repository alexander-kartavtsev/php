<?php
const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
?>
<div class="page_content counter_page">
      <h1>Счетчик пользователя login</h1>
      <div class="counter_wrapper">
        <div class="counter_auth">
          <h2>Количество посещений</h2>
          <div class="counter_number"><span>24</span></div>
        </div>
        <div class="counter_custom">
          <h2>Просто число</h2>
          <div class="counter_number">
            <span>15</span>
            <div class="buttons">
              <button class="plus">+</button>
              <button class="minus">-</button>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
