<?php
const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
$couner = new Counter();
?>
<div class="page_content counter_page">
      <h1>Счетчик пользователя login</h1>
      <div class="counter_wrapper">
        <div class="counter_auth">
          <h2>Количество посещений</h2>
          <div class="counter_number"><span><?= $couner->getVisits() ?></span></div>
        </div>
        <div class="counter_custom">
          <h2>Просто число</h2>
          <div class="counter_number">
            <span id="number"><?= $couner->getNumber() ?></span>
            <div class="buttons">
              <button class="minus" id="btn-minus">-</button>
              <button class="plus" id="btn-plus">+</button>
            </div>
          </div>
        </div>
      </div>
    </div>
<script src="/js/pages/counters.js"></script>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
