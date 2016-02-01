<?php

use yii\helpers\Url;
use frontend\models\User2Image;

// USER ID
$userId = Yii::$app->user->id;

// AVATAR
$avatar   = User2Image::getAvatar($userId);

?>

<section class="profile-box box block">

    <?php if($avatar): ?>
        <img src="<?= $avatar ?>" alt="" />
    <?php else: ?>
        <img src="/img/no-avatar.png" />
    <?php endif; ?>

    <div class="profile-box-options">
        <span><?= Yii::$app->user->identity->firstname ?></span>
        <a href="<?= Url::to(['profile/edit']) ?>" class="pull-left">
            <?= Yii::t('profile', 'user_settings') ?>
        </a>
        <a href="<?= Url::to(['auth/logout']) ?>" class="pull-right" data-method="post">
            <?= Yii::t('profile', 'user_logout') ?>
        </a>
    </div>
</section>