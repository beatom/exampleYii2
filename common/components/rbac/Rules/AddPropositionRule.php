<?php

namespace common\components\rbac\Rules;

use Yii;
use yii\rbac\Rule;

class AddPropositionRule extends Rule
{

    public $name = 'addProposition';

    public function execute($user, $item, $params)
    {

        if($user != $params['sellerId']) {
            return true;
        }

        return false;
    }
}
