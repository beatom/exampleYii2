<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\Rules\UserRoleRule;
use common\components\rbac\Rules\AddPropositionRule;
use common\components\rbac\Rules\ConfirmPhoneRule;
use common\components\rbac\Rules\ChangePropositionInterestRule;
use common\components\rbac\Rules\EnterNewPhoneRule;
use common\components\rbac\Rules\RemovePhoneResendCodeShowLink;
use common\components\rbac\Rules\ConfirmPhoneResendCodeShowLink;

class RbacController extends Controller
{

    public function actionInit()
    {

        $authManager = Yii::$app->authManager;

        // ROLES
        $guest      = $authManager->createRole('guest');
        $confirmed  = $authManager->createRole('confirmed');
        $user       = $authManager->createRole('user');
        $admin      = $authManager->createRole('admin');


        // RULES
        $userGroupRule = new UserRoleRule();
        $authManager->add($userGroupRule);

        $addPropositionRule = new AddPropositionRule();
        $authManager->add($addPropositionRule);

        $confirmPhoneRule = new ConfirmPhoneRule();
        $authManager->add($confirmPhoneRule);

        $changePropositionInterestRule = new ChangePropositionInterestRule();
        $authManager->add($changePropositionInterestRule);

        $enterNewPhone = new EnterNewPhoneRule();
        $authManager->add($enterNewPhone);

        $removePhoneResendCodeShowLink = new RemovePhoneResendCodeShowLink();
        $authManager->add($removePhoneResendCodeShowLink);

        $confirmPhoneResendCodeShowLink = new ConfirmPhoneResendCodeShowLink();
        $authManager->add($confirmPhoneResendCodeShowLink);


        // Add rule "UserGroupRule" in roles
        $guest->ruleName      = $userGroupRule->name;
        $confirmed->ruleName  = $userGroupRule->name;
        $user->ruleName       = $userGroupRule->name;
        $admin->ruleName      = $userGroupRule->name;


        // ADD ROLES TO AUTH_MANAGER
        $authManager->add($guest);
        $authManager->add($confirmed);
        $authManager->add($user);
        $authManager->add($admin);


        // PERMISSIONS
        $addPropositionPermission = $authManager->createPermission('addProposition');
        $addPropositionPermission->ruleName = $addPropositionRule->name;
        $authManager->add($addPropositionPermission);

        $confirmPhonePermission = $authManager->createPermission('confirmPhone');
        $confirmPhonePermission->ruleName = $confirmPhoneRule->name;
        $authManager->add($confirmPhonePermission);

        $changePropositionInterestPermission = $authManager->createPermission('changePropositionInterest');
        $changePropositionInterestPermission->ruleName = $changePropositionInterestRule->name;
        $authManager->add($changePropositionInterestPermission);

        $enterNewPhonePermission = $authManager->createPermission('enterNewPhone');
        $enterNewPhonePermission->ruleName = $enterNewPhone->name;
        $authManager->add($enterNewPhonePermission);

        $removePhoneResendCodeShowLinkPermission = $authManager->createPermission('removePhoneResendCodeShowLink');
        $removePhoneResendCodeShowLinkPermission->ruleName = $removePhoneResendCodeShowLink->name;
        $authManager->add($removePhoneResendCodeShowLinkPermission);

        $confirmPhoneResendCodeShowLinkPermission = $authManager->createPermission('confirmPhoneResendCodeShowLink');
        $confirmPhoneResendCodeShowLinkPermission->ruleName = $confirmPhoneResendCodeShowLink->name;
        $authManager->add($confirmPhoneResendCodeShowLinkPermission);


        // ADD PERMISSIONS TO ROLES
        $authManager->addChild($confirmed, $confirmPhonePermission);
        $authManager->addChild($confirmed, $enterNewPhonePermission);
        $authManager->addChild($confirmed, $confirmPhoneResendCodeShowLinkPermission);
        $authManager->addChild($user, $addPropositionPermission);
        $authManager->addChild($user, $changePropositionInterestPermission);
        $authManager->addChild($user, $removePhoneResendCodeShowLinkPermission);
    }
}
