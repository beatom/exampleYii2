<?php

use yii\helpers\Url;
use common\vendor\FileManager\Manager\FileFactory;
use common\models\Proposition;
use frontend\models\AmountService;

$options = Yii::$app->params;
$fileManager = FileFactory::factory((object)$options['fileManager']);

?>

<?php

// FILE MANAGER
$fileManager->setAsset('announcement', ['id' => $exchange['id']]);
$filepath = '/' . $fileManager->getPath($exchange['image'], 'preview');

// HREF
$href = Url::to(['catalog/view', 'id' => $exchange['id']]);

// SURCHARGE
$surcharge = '';
switch($proposition['surcharge']) {
    case Proposition::SURCHARGE_OFFERING:
        $surcharge = Yii::t('profile', 'propositions_surcharge_offering');
        break;
    case Proposition::SURCHARGE_SELLER:
        $surcharge = Yii::t('profile', 'propositions_surcharge_seller');
        break;
}

?>

<div class="offers-list-exchange">
    <a href="<?= $href ?>" class="offers-list-image">
        <img src="<?= $filepath ?>" />
    </a>

    <div class="col">
        <a href="<?= $href ?>" class="offers-list-title">
            <?= $exchange['brand'] ?>
            <?= $exchange['model'] ?>
            <?= $exchange['year'] ?>
        </a>

        <p>
            +
            <?= AmountService::getInstance()->getUsdPriceWithSymbol($proposition['amount_display']); ?>
            <?= $surcharge ?>
        </p>
    </div>
</div>