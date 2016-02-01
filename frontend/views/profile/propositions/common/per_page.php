<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="pull-right">
    <?php
        // PARAMS
        $params = [$action] + Yii::$app->request->queryParams;

        // VALUE
        $value = '';
        if(isset(Yii::$app->request->queryParams[$paramName]) &&
                 Yii::$app->request->queryParams[$paramName]) {
            $value = Yii::$app->request->queryParams[$paramName];
        }

        // SELECT PARAMS FOR URLS
        $paramsPp10 = $params;
        $paramsPp20 = $params;
        $paramsPp50 = $params;

        $paramsPp10[$paramName] = 10;
        $paramsPp20[$paramName] = 20;
        $paramsPp50[$paramName] = 50;

        $paramsPp10['type'] = $type;
        $paramsPp20['type'] = $type;
        $paramsPp50['type'] = $type;

        // SELECT OPTIONS DATA
        $data = [
            10 => Yii::t('ads', 'show_by') . ' 10',
            20 => Yii::t('ads', 'show_by') . ' 20',
            50 => Yii::t('ads', 'show_by') . ' 50',
        ];

        // OPTIONS PARAMS
        $options = [
            10 => ['href' => Url::to($paramsPp10)],
            20 => ['href' => Url::to($paramsPp20)],
            50 => ['href' => Url::to($paramsPp50)]
        ];

        echo Html::dropDownList($paramName, $value, $data, [
            'class' => 'chosen-select-no-single',
            'id'    => $id,
            'options' => $options
        ]);
    ?>
</div>