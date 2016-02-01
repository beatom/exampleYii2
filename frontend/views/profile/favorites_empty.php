<?php

use yii\helpers\Url;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_favorites')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_favorites')
        ]); ?>

        <section class="profile-page">

            <!-- HEAD -->
            <div class="heading">
                <h1 class="profile-header-fav"><?= Yii::t('profile', 'favorites') ?> (0)</h1>
            </div>

            <div class="empty-box profile-fav-empty">
                <p><?= Yii::t('profile', 'empty_favorites') ?></p>
                <a href="<?= Url::to('/catalog') ?>" class="button button-important button-search-lite">
                    <?= Yii::t('profile', 'empty_favorites_button') ?>
                </a>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 2]) ?>