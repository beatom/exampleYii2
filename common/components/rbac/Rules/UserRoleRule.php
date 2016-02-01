<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

// http://www.yiiframework.com/doc-2.0/guide-security-authorization.html
class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {

        if (!\Yii::$app->user->isGuest) {

            $role = \Yii::$app->user->identity->role;

            if ($item->name === 'confirmed') {
                return $role == User::ROLE_CONFIRMED;
            }
            elseif ($item->name === 'user') {
                return $role == User::ROLE_USER;
            }
            elseif ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            }
        }

        return false;
    }
}