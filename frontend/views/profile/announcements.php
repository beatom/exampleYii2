<?php

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
                <h1 class="profile-header-advs"><?= Yii::t('profile', 'announcement') ?> (<?= $dataProvider->getTotalCount() ?>)</h1>

                <!-- TOOLS -->
                <div class="tools clearfix">

                    <!-- SORT -->
                    <?php echo $this->render('/partials/filters/sort_price', [
                        'action' => 'announcements'
                    ]); ?>
                </div>
            </div>

            <!-- LIST -->
            <ul class="search-result">
                <?php echo $this->render('announcements/list', [
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
                    'action' => 'announcements'
                ]); ?>
            </div>

        </section>
    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>