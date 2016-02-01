<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;
use common\models\User;

class ConfirmPhoneRule extends Rule
{

    public $name = 'confirmPhone';

    public function execute($user, $item, $params)
    {

        if (!\Yii::$app->user->isGuest) {

            $role = \Yii::$app->user->identity->role;
            if($role == User::ROLE_CONFIRMED) {
                return true;
            }
        }

        return false;
    }
}
