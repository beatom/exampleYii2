<?php

use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'subscribeForm']); ?>
<div class="half">

    <!-- ALL -->
    <div class="check-box block clearfix">
        <span class="niceCheck">
            <input type="checkbox" class="niceCheck checkAll" id="mailsubscribe-all">
        </span>
        <label class="checkbox-label" for="mailsubscribe-all">
            <?= Yii::t('profile', 'subscribe_label_all') ?>
        </label>
    </div>

    <!-- NEWS -->
    <?php
        echo $form->field($model, 'news', [
            'options' => [
                'tag' => 'div',
                'class' => 'check-box block clearfix'
            ],
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'mailsubscribe-news',
                'style' => 'display: none;'
            ],
            'template' => "<span class='niceCheck autoCheck'>{input}</span>{label}{error}",
        ])->checkbox([], false);
    ?>

    <!-- NEW ANNOUNCEMENTS -->
    <?php
        echo $form->field($model, 'new_announcement', [
            'options' => [
                'tag' => 'div',
                'class' => 'check-box block clearfix'
            ],
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'mailsubscribe-new_announcement',
                'style' => 'display: none;'
            ],
            'template' => "<span class='niceCheck autoCheck'>{input}</span>{label}{error}",
        ])->checkbox([], false);
    ?>
</div>

<div class="half">

    <!-- NEW PROPOSITION -->
    <?php
        echo $form->field($model, 'new_proposition', [
            'options' => [
                'tag' => 'div',
                'class' => 'check-box block clearfix'
            ],
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'mailsubscribe-new_proposition',
                'style' => 'display: none;'
            ],
            'template' => "<span class='niceCheck autoCheck'>{input}</span>{label}{error}",
        ])->checkbox([], false);
    ?>

    <!-- PROPOSITION RESPONSE -->
    <?php
        echo $form->field($model, 'proposition_response', [
            'options' => [
                'tag' => 'div',
                'class' => 'check-box block clearfix'
            ],
            'labelOptions' => [
                'class' => 'checkbox-label',
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'mailsubscribe-proposition_response',
                'style' => 'display: none;'
            ],
            'template' => "<span class='niceCheck autoCheck'>{input}</span>{label}{error}",
        ])->checkbox([], false);
    ?>
</div>

<div class="clear"></div>
<?php ActiveForm::end(); ?>