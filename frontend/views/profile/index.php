<?php

use yii\helpers\Url;
use common\models\service\Plural;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

$this->render('/partials/title', [
    'title' => Yii::t('app', 'title_profile')
]);

?>

<article>
    <section class="profile box block">
        <div class="two-cols-box clearfix">

            <!-- ICONS -->
            <div class="two-cols-box-main clearfix">
                <ul class="profile-options">

                    <!-- ANNOUNCEMENTS -->
                    <li>
                        <a href="<?= Url::to(['announcements']) ?>"><?= Yii::t('profile', 'icons_my_advertisements') ?></a>
                        <?php if($countAnnouncement): ?>
                            <p>
                                <?= Yii::t('profile', 'icons_my_advertisements_you_have') ?>
                                <?= $countAnnouncement ?>
                                <?= Plural::plural($countAnnouncement, [
                                    Yii::t('profile', 'plural_announcement_1'),
                                    Yii::t('profile', 'plural_announcement_2'),
                                    Yii::t('profile', 'plural_announcement_3')
                                ]) ?>
                            </p>
                        <?php endif; ?>
                    </li>

                    <!-- PROPOSITIONS -->
                    <li>
                        <a href="<?= Url::to(['propositions']) ?>">
                            <?= Yii::t('profile', 'icons_propositions') ?>
                            <?php if($countPropositions): ?>
                                <span><?= $countPropositions ?></span>
                            <?php endif; ?>
                        </a>
                        <p><?= Yii::t('profile', 'icons_propositions_message') ?></p>
                    </li>

                    <!-- FAVORITES -->
                    <li>
                        <a href="<?= Url::to(['favorites']) ?>">
                            <?= Yii::t('profile', 'icons_favorites') ?>
                        </a>
                        <p><?= Yii::t('profile', 'icons_favorites_message') ?></p>
                    </li>

                    <!-- EDIT -->
                    <li>
                        <a href="<?= Url::to(['edit']) ?>">
                            <?= Yii::t('profile', 'icons_contacts') ?>
                        </a>
                        <p><?= Yii::t('profile', 'icons_contacts_message') ?></p>
                    </li>

                    <!-- SUBSCRIBE -->
                    <li>
                        <a href="<?= Url::to(['subscribe']) ?>"><?= Yii::t('profile', 'icons_notice') ?></a>
                        <p><?= Yii::t('profile', 'icons_notice_message') ?></p>
                    </li>

                    <!-- SECURITY -->
                    <li>
                        <a href="<?= Url::to(['change-password']) ?>"><?= Yii::t('profile', 'icons_security') ?></a>
                        <p><?= Yii::t('profile', 'icons_security_message') ?></p>
                    </li>
                </ul>
            </div>

            <!-- USER -->
            <div class="two-cols-box-aside">
                <?php echo $this->render('partials/user', []); ?>
            </div>

        </div>
    </section>

    <!-- BLOCKS -->
    <section class="block clearfix">
        <div class="more-box questions full-width">
            <span><?= Yii::t('profile', 'block_support_reono') ?></span>
            <p>
                <?= Yii::t('profile', 'block_support_have_questions') ?><br />
                <?= Yii::t('profile', 'block_support_contact_support') ?>
            </p>
            <a class="button button-lite" href="<?= Url::to(['site/feedback']) ?>">
                <?= Yii::t('profile', 'block_support_write_message') ?>
            </a>
        </div>
    </section>

    <!-- FAQ -->
    <?php if(count($faq)): ?>
        <section class="box block">
            <h5><?= Yii::t('app', 'faq_profile') ?></h5>
            <?php echo $this->render('/partials/faq', [
                'faq' => $faq
            ]); ?>
        </section>
    <?php endif; ?>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>
