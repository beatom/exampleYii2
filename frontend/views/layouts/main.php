<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Announcement;
use frontend\assets\AllMinAsset;

if(YII_ENV == 'dev') {
    AppAsset::register($this);
}
else {
    AllMinAsset::register($this);
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="/img/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/img/fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/fav/favicon-16x16.png">
    <link rel="manifest" href="/img/fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/fav/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?php $this->head() ?>
</head>

<?php
$controller = Yii::$app->controller->id;
$action     = Yii::$app->controller->action->id;

// BODY CLASS
$bodyClass = '';
if($controller == 'site' && $action == 'index') {
    $bodyClass = 'class="mainpage"';
}

// WRAPPER CLASS
$wrapperClass = '';
if($controller == 'auth' && $action == 'signup' ||
   $controller == 'auth' && $action == 'login') {
    $wrapperClass = 'reg-page';
}

// CONTAINER CLASS
$containerClass = '';
if(($controller == 'catalog' && $action == 'index')) {
    $containerClass = 'three-cols';
}

// CONTAINER SECTION CLASS
$contentSectionClass = '';
if(($controller == 'catalog' && $action == 'view')) {
    $contentSectionClass = 'three-cols-special';
}

?>

<body <?= $bodyClass ?>>
    <?php $this->beginBody() ?>
    <div class="wrapper <?= $wrapperClass ?>">

        <!-- HEADER -->
        <header>
            <div class="container">
                <div class="header-toolbox">
                    <div class="pull-left">
                        <?php echo Html::a(Html::encode(Yii::t('app', 'layout_sell_car')), Url::to(['announcement/create']), ['class' => 'button button-important button-plus']); ?>
                    </div>

                    <?php echo $this->render('/partials/user-panel'); ?>
                </div>

                <!-- LOGO -->
                <?php echo Html::a('', ['/'], ['class' => 'logo']) ?>

                <span class="intro-text"><?= Yii::t('app', 'layout_main_title') ?></span>

                <!-- CREATED YESTARDAY -->
                <?php if($controller == 'site' && $action == 'index'): ?>

                    <?php
                        $db = Yii::$app->db;
                        $yestardayCreated = $db->cache(function($db) {
                            $yestardayCreated = Announcement::find()
                                                    ->andWhere('DATE(date_created) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))')
                                                    ->count();
                            return $yestardayCreated;
                        }, Yii::$app->params['24hourCache']);
                    ?>
                    <?php if($yestardayCreated): ?>
                        <div class="header-new">
                            <div class="header-new-text"><span><?/*= $yestardayCreated */?></span>добавлено вчера!</div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </header>
        <!-- END HEADER -->

        <!-- MESSAGES -->
        <?php echo $this->render('/partials/messages/success'); ?>
        <?php echo $this->render('/partials/messages/error'); ?>
        <?php echo $this->render('/partials/messages/info'); ?>
        <!-- END MESSAGES -->

        <!-- CONTENT -->
        <section class="content <?= $contentSectionClass ?>">
            <div class="container <?= $containerClass ?>">
                <?php echo $content ?>
            </div>
        </section>
        <!-- END CONTENT -->
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="copyright"><span><?php echo date('Y') ?></span>&copy; Reono.ua</div>
            <?php echo $this->render('/partials/footer/navigation.php'); ?>
        </div>
    </footer>
    <!-- END FOOTER -->

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
