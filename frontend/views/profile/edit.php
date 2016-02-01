<?php

use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_edit')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_edit')
        ]); ?>

        <section class="profile-page">

            <div class="heading">
                <h1 class="profile-header-contacts"><?= Yii::t('profile', 'edit') ?></h1>
            </div>

            <!-- FORM -->
            <?php echo $this->render('edit/form', [
                'model'     => $model,
                'images'    => $images,
                'mainImage' => $mainImage,
                'user'      => $user
            ]) ?>
        </section>
    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>