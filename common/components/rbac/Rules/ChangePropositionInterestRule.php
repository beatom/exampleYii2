<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;

class ChangePropositionInterestRule extends Rule
{

    public $name = 'changePropositionInterest';

    public function execute($user, $item, $params)
    {

        if($user == $params['sellerId']) {
            return true;
        }

        return false;
    }
}
