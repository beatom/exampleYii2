<?php

use yii\helpers\Url;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile_hidden')
]);

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_hidden')
        ]); ?>

        <section class="profile-page">

            <!-- HEAD -->
            <div class="heading">
                <h1 class="profile-header-fav">
                    <?= Yii::t('profile', 'dont_show') ?>
                    (<?= $dataProvider->getTotalCount() ?>)
                </h1>

                <!-- TOOLS -->
                <div class="tools clearfix">

                    <!-- FAVORITES AUTO COUNT -->
                    <?php if($countFavorites): ?>
                        <div class="fav-hidden">
                            <a href="<?= Url::to(['profile/favorites']) ?>">
                                <?= Yii::t('profile', 'in_favorites') ?>
                                <?= $countFavorites ?>
                                <?= Yii::t('profile', 'auto') ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- SORT -->
                    <?php echo $this->render('/partials/filters/sort_price', [
                        'action' => 'hidden'
                    ]); ?>
                </div>
            </div>

            <!-- LIST -->
            <ul class="search-result">
                <?php echo $this->render('hidden/list', [
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
                    'action' => 'hidden'
                ]); ?>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>
