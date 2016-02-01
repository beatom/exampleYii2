<?php

use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_subscribe')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_subscribe')
        ]); ?>

        <section class="profile-page">
            <div class="heading">
                <h1 class="profile-header-notifications">
                    <?= Yii::t('profile', 'subscribe') ?>
                </h1>
            </div>

            <div class="block">
                <p>
                    <strong><?= Yii::t('profile', 'subscribe_question') ?></strong>
                </p>
                <br />

                <?php echo $this->render('subscribe/form', [
                    'model' => $model,
                ]); ?>
            </div>

            <br />
            <br />
            <br />
            <br />
            <br />

            <div class="clearfix">
                <a href="" id="save" class="button button-important pull-left">
                    <?= Yii::t('profile', 'subscribe_button_save') ?>
                </a>
                <a href="" id="cancel" class="button button-link pull-right">
                    <?= Yii::t('profile', 'subscribe_button_cancel') ?>
                </a>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>