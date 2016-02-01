<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\vendor\FileManager\Manager\FileFactory;
use frontend\models\AmountService;

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
        <a href="<?= $href ?>" class="search-result-box">

            <!-- PHOTO -->
            <img src="<?= $filepath ?>" />

            <?php echo $this->render('/partials/auto_long_block_search', [
                'row'               => $row,
                'filepath'          => $filepath,
                'href'              => $href,
                'mileage'           => $mileage,
                'fuelSystem'        => $fuelSystem,
                'fuelSystemForList' => $fuelSystemForList
            ]); ?>
        </a>
    </li>
<?php endforeach; ?>
