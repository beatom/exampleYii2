<?php

use yii\helpers\Url;
use common\vendor\FileManager\Manager\FileFactory;
use common\models\Announcement;

$options = Yii::$app->params;
$fileManager = FileFactory::factory((object)$options['fileManager']);

?>

<?php foreach($dataProvider->getModels() as $row): ?>

    <?php
        // FILE MANAGER
        $fileManager->setAsset('announcement', ['id' => $row['id']]);
        $filepath = '/' . $fileManager->getPath($row['image'], 'preview');

        // HREF
        $href = Url::to(['catalog/view', 'id' => $row['id']]);

        // MILEAGE
        Yii::$app->formatter->thousandSeparator = ' ';
        $mileage = Yii::$app->formatter->asInteger($row['mileage'] * 1000);
        $mileage .= ' ' . Yii::t('ads', 'km');

        // FUEL SYSTEM
        $fuelSystem = '';
        $fuelSystemForList = '';
        if($row['fuel_system']) {
            $fuelSystem = Yii::t('ads', $row['fuel_system']);
            if($row['engine_capacity']) {
                $fuelSystemForList = Yii::t('ads', $row['fuel_system']) . ' ' . $row['engine_capacity'] . ', ';
            }
            else {
                $fuelSystemForList = Yii::t('ads', $row['fuel_system']) . ', ';
            }
        }
    ?>

    <li>
        <div class="search-result-box">

            <!-- PHOTO -->
            <?php if($row['status'] == Announcement::STATUS_SALES): ?>
                <div class="sold">
                    <a href="<?= $href ?>">
                        <img src="<?= $filepath ?>" />
                    </a>
                </div>
            <?php else: ?>
                <a href="<?= $href ?>">
                    <img src="<?= $filepath ?>" />
                </a>
            <?php endif; ?>

            <?php echo $this->render('/partials/auto_long_block_search_with_links', [
                'row'               => $row,
                'filepath'          => $filepath,
                'href'              => $href,
                'mileage'           => $mileage,
                'fuelSystem'        => $fuelSystem,
                'fuelSystemForList' => $fuelSystemForList,
                'profile_buttons'   => true
            ]); ?>

            <div class="search-result-box-buttons">
                <a href="<?= Url::to(['announcement/edit', 'id' => $row['id']]) ?>" class="button button-lite button-edit">
                    <?= Yii::t('profile', 'announcement_button_edit') ?>
                </a>

                <?php if($row['status'] == Announcement::STATUS_ENABLED): ?>
                    <a href="<?= Url::to(['announcement/sales', 'id' => $row['id']]) ?>" class="button button-lite button-success bold profile_sales">
                        <?= Yii::t('profile', 'announcement_button_sales') ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </li>
<?php endforeach; ?>
