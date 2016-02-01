<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;
use common\models\User;

class EnterNewPhoneRule extends Rule
{

    public $name = 'enterNewPhone';

    public function execute($user, $item, $params)
    {

        // Гость не может вводить новый телефон
        if(Yii::$app->user->isGuest) {
            return false;
        }

        // Новый телефон может вводить только CONFIRMED
        $role = Yii::$app->user->identity->role;
        if($role != User::ROLE_CONFIRMED) {
            return false;
        }

        // Если телефон есть, то новый вводить не можем, пока не удалим старый
        $phone = Yii::$app->user->identity->phone;
        if($phone) {
            return false;
        }

        return true;
    }
}
