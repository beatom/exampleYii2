<?php

use frontend\models\AmountService;

?>

<?php

// OFFER PRICE
$offerUsdPrice = AmountService::getInstance()->getUsdPriceWithSymbol($offeringPrice, ' ');
$offerUahPrice = AmountService::getInstance()->getUahPriceWithSymbol($offeringPrice);

// MY PRICE
$announcementUsdPrice = AmountService::getInstance()->getUsdPriceWithSymbol($announcementPrice, ' ');
$announcementUahPrice = AmountService::getInstance()->getUahPriceWithSymbol($announcementPrice);

?>

<div class="offers-list-p1">
    <span><?= $offerUsdPrice ?></span>
    <?= $offerUahPrice ?>
</div>

<div class="offers-list-p2">
    <span><?= $announcementUsdPrice ?></span>
    <?= $announcementUahPrice ?>
</div>
