<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php

    // ACTION
    $action = 'propositions';

    // PARAMS
    $params = [$action] + Yii::$app->request->queryParams;

    // PARAM NAME
    $paramName = "interest_$type";

    // VALUE
    $value = '';
    if(isset(Yii::$app->request->queryParams[$paramName]) &&
             Yii::$app->request->queryParams[$paramName]) {
        $value = Yii::$app->request->queryParams[$paramName];
    }

    // PARAMS FOR HREF
    $paramsAll      = $params;
    $paramsActive   = $params;
    $paramsAccepted = $params;
    $paramsDeclined = $params;

    // INTEREST
    $paramsAll[$paramName]      = 'all';
    $paramsActive[$paramName]   = 'active';
    $paramsAccepted[$paramName] = 'accepted';
    $paramsDeclined[$paramName] = 'declined';

    // TYPE (TAB)
    $paramsAll['type']      = $type;
    $paramsActive['type']   = $type;
    $paramsAccepted['type'] = $type;
    $paramsDeclined['type'] = $type;

    // SELECT OPTIONS DATA
    $data = [
        'all'      => Yii::t('profile', 'propositions_filter_all'),
        'active'   => Yii::t('profile', 'propositions_filter_active'),
        'accepted' => Yii::t('profile', 'propositions_filter_accepted'),
        'declined' => Yii::t('profile', 'propositions_filter_declined')
    ];

    // OPTIONS PARAMS
    $options = [
        'all'      => ['href' => Url::to($paramsAll)],
        'active'   => ['href' => Url::to($paramsActive)],
        'accepted' => ['href' => Url::to($paramsAccepted)],
        'declined' => ['href' => Url::to($paramsDeclined)]
    ];

    echo Html::dropDownList($paramName, $value, $data, [
        'class'   => 'chosen-select-no-single',
        'id'      => $id,
        'options' => $options
    ]);
?>
