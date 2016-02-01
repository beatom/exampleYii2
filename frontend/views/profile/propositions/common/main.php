<?php

use yii\helpers\Url;
use common\vendor\FileManager\Manager\FileFactory;
use common\models\Proposition;

$options = Yii::$app->params;
$fileManager = FileFactory::factory((object)$options['fileManager']);

?>

<?php

    $classShort = '';
    if($proposition['announcement_exchange_id']) {
        $classShort = 'short';
    }

    // FILE MANAGER
    $fileManager->setAsset('announcement', ['id' => $announcement['id']]);
    $filepath = '/' . $fileManager->getPath($announcement['image'], 'preview');

    // HREF
    $href = Url::to(['catalog/view', 'id' => $announcement['id']]);

    // DATE AND TIME
    $timastamp   = strtotime($proposition['date_created']);
    $dateCreated = date('d.m.Y', $timastamp);
    $timeCreated = date('H:i', $timastamp);

    // PHONE
    $phone = preg_replace('/[^0-9]/', '', (string) $phone);
    $phoneHidden = mb_substr($phone, 0, 3) . 'xxxxxxx';

    $phone = '+38' . $phone;
    $phoneHidden = '+38' . $phoneHidden;

    // INTEREST
    $interestClass = 'active';
    $interestText  = Yii::t('profile', 'propositions_interest_active');

    switch($proposition['exchange_seller_interest']) {
        case Proposition::EXCHANGE_SELLER_INTEREST_YES:
            $interestClass = 'accepted';
            $interestText  = Yii::t('profile', 'propositions_interest_accepted');
            break;
        case Proposition::EXCHANGE_SELLER_INTEREST_NO:
            $interestClass = 'declined';
            $interestText  = Yii::t('profile', 'propositions_interest_declined');
            break;
        default:
            $interestClass = 'active';
            $interestText  = Yii::t('profile', 'propositions_interest_active');
            break;
    }
?>

<div class="offers-list-main <?= $classShort ?>">

    <!-- PHOTO -->
    <a href="<?= $href ?>" class="offers-list-image">
        <img src="<?= $filepath ?>" />
    </a>

    <div class="col">
        <div class="offers-list-info clearfix">

            <!-- INTEREST -->
            <div class="offers-list-status <?= $interestClass ?>">
                <?= $interestText ?>
            </div>

            <!-- DATE -->
            <div class="offers-list-date">
                <?= $dateCreated ?>
            </div>

            <!-- TIME -->
            <div class="offers-list-time">
                <?= $timeCreated ?>
            </div>

            <!-- NAME -->
            <div class="offers-list-name">
                <?= $name ?>
            </div>

            <!-- PHONE -->
            <div class="offers-list-phone" data-phone="<?= $phone ?>">
                <?= $phoneHidden ?>
            </div>
        </div>

        <!-- BRAND/MODEL/YEAR -->
        <a href="<?= $href ?>" class="offers-list-title">
            <?= $announcement['brand'] ?>
            <?= $announcement['model'] ?>
            <?= $announcement['year'] ?>
        </a>
    </div>
</div>