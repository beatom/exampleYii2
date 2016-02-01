<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;
use common\models\UserRemovePhoneTimeSmsLink;

class RemovePhoneResendCodeShowLink extends Rule
{

    public $name = 'removePhoneResendCodeShowLink';

    public function execute($user, $item, $params)
    {

        if(Yii::$app->user->isGuest) {
            return false;
        }

        $userId   = Yii::$app->user->id;
        $interval = Yii::$app->params['remove_phone_interval_sms_link'];

        $showLink = UserRemovePhoneTimeSmsLink::find()
                ->select([
                    'showLink' => "CASE WHEN DATE_SUB(NOW(), INTERVAL $interval SECOND) > date_send THEN 1 ELSE 0 END"
                ])
                ->andFilterWhere(['user_id' => $userId])
                ->asArray()
                ->one();
        if(!count($showLink)) {
            return true;
        }

        $showLink = array_shift($showLink);
        if(!$showLink) {
            return false;
        }

        return true;
    }
}
