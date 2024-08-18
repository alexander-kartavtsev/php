<?php
const NEED_AUTH = true;
require $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
/** @var Page $page */
$counter = new Counter();
$user = new CurrentUser();
$page->addPageScript('/js/pages/counters.js');
?>
<div class="page_content counter_page">
  <h1>Счетчик пользователя <?=$user->getName()?>(<?=$user->getLogin()?>)</h1>
  <div class="counter_wrapper">
    <div class="counter_auth">
      <h2>Количество посещений</h2>
      <div class="counter_number"><span><?= $counter->getVisits() ?></span></div>
    </div>
    <div class="counter_custom">
      <h2>Просто число</h2>
      <div class="counter_number">
        <span id="number"><?= $counter->getNumber() ?></span>
        <div class="buttons">
          <button class="minus" id="btn-minus">-</button>
          <button class="plus" id="btn-plus">+</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
