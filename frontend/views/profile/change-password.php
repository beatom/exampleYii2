<?php

use yii\bootstrap\ActiveForm;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->title = Yii::t('user', 'change_password_profile_title');

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_security')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_security')
        ]); ?>

        <section class="profile-page">
            <div class="heading">
                <h1 class="profile-header-security">
                    <?= Yii::t('profile', 'security') ?>
                </h1>
            </div>

            <div class="block">
                <h5><?= Yii::t('profile', 'security_contact_info') ?></h5>

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                    <?php echo $this->render('change-password/form', [
                        'model' => $model,
                        'form'  => $form
                    ]) ?>
                <?php ActiveForm::end(); ?>
            </div>

            <div class="clearfix">
                <a href="" id="save" class="button button-important pull-left">
                    <?= Yii::t('profile', 'security_button_save') ?>
                </a>
                <a href="" id="cancel" class="button button-link pull-right">
                    <?= Yii::t('profile', 'security_button_cancel') ?>
                </a>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>
