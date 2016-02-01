<?php

use yii\helpers\Url;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_announcements')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_announcements')
        ]); ?>

        <section class="profile-page">

            <!-- HEAD -->
            <div class="heading">
                <h1 class="profile-header-advs"><?= Yii::t('profile', 'announcement') ?> (0)</h1>
            </div>

            <div class="empty-box profile-advs-empty">
                <p><?= Yii::t('profile', 'empty_announcements') ?></p>
                <a href="<?= Url::to(['announcement/create']) ?>" class="button button-important button-plus">
                    <?= Yii::t('profile', 'empty_announcements_button') ?>
                </a>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 2]) ?>