<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_remove_phone')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_remove_phone')
        ]); ?>

        <!-- FORM -->
        <section class="profile-page">
            <div class="change-data">
                <h2><?= Yii::t('user', 'caption_remove_phone') ?></h2>

                <?php \yii\widgets\Pjax::begin(); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'confirmed-phone-form',
                    'options' => [
                        'autocomplete' => 'off'
                    ]
                ]); ?>
                    <table class="form-inline">
                        <tr>
                            <td>
                                <label><?= Yii::t('user', 'label_phone_confirm_code') ?></label>
                            </td>

                            <?php echo $form->field($model, 'code', [
                                'options' => [
                                    'tag' => 'td'
                                ],
                                'inputOptions' => [
                                    'class' => 'textfield textfield-lite',
                                ],
                                'errorOptions' => [
                                    'tag'   => 'span',
                                    'class' => 'error-text',
                                    'style' => 'display: none; width:130px;',
                                    'for'   => 'confirmedphone-code'
                                ],
                                'template' => '{input}{error}'
                            ]); ?>

                            <td>
                                <?php echo Html::submitButton(Yii::t('user', 'confirm_phone_submit'), ['class' => 'button button-success bold']) ?>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td colspan="2">
                                <?php if(Yii::$app->user->can('removePhoneResendCodeShowLink')): ?>
                                    <?= Yii::t('user', 'confirm_phone_no_code') ?>
                                    <br>
                                    <?php echo Html::a(Yii::t('user', 'confirm_phone_send_again'), ['profile/remove-phone-resend']) ?>
                                <?php else: ?>
                                    <?= Yii::t('user', 'can_resend_code_again') ?>
                                    <?= $waitingTime ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                <?php ActiveForm::end(); ?>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 2]) ?>
