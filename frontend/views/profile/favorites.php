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
                <h1 class="profile-header-fav">
                    <?= Yii::t('profile', 'favorites') ?>
                    (<?= $dataProvider->getTotalCount() ?>)
                </h1>

                <!-- TOOLS -->
                <div class="tools clearfix">

                    <!-- HIDDEN AUTO -->
                    <?php if($countHiddenAnnouncements): ?>
                        <div class="fav-hidden">
                            <a href="<?= Url::to(['profile/hidden']) ?>">
                                <?= Yii::t('profile', 'dont_show') ?>
                                <?= $countHiddenAnnouncements ?>
                                <?= Yii::t('profile', 'auto') ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- SORT -->
                    <?php echo $this->render('/partials/filters/sort_price', [
                        'action' => 'favorites'
                    ]); ?>
                </div>

            </div>

            <!-- LIST -->
            <ul class="search-result fav-list">
                <?php echo $this->render('favorites/list', [
                    'dataProvider' => $dataProvider,
                ]); ?>
            </ul>

            <!-- PAGINATION -->
            <div class="toolbox clearfix">
                <?php echo $this->render('/partials/filters/paginator', [
                    'dataProvider' => $dataProvider
                ]); ?>

                <!-- PER PAGE -->
                <?php echo $this->render('/partials/filters/per_page', [
                    'action' => 'favorites'
                ]); ?>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>
