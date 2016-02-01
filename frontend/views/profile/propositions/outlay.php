<?php

use common\models\Proposition;
use frontend\models\Profile\Proposition as ProfilePropositionService;

?>

<?php

    $style = 'display: none;';
    if($outlayClass) {
        $style = 'display: block;';
    }
?>

<div class="tab" style="<?= $style ?>">

    <?php if($outlayDataProvider->getTotalCount()): ?>
        <ul class="offers-list-header clearfix">
            <li><?= Yii::t('profile', 'propositions_income_heading_auto') ?></li>
            <li><?= Yii::t('profile', 'propositions_income_heading_your_price') ?></li>
            <li><?= Yii::t('profile', 'propositions_income_heading_seller_price') ?></li>
        </ul>

        <ul class="offers-list">
            <?php foreach($outlayDataProvider->getModels() as $row): ?>
                <li>

                    <?php $announcement = $outlayAnnouncements[$row['announcement_id']]; ?>

                    <!-- MAIN -->
                    <?php echo $this->render('common/main', [
                        'proposition'  => $row,
                        'name'         => $announcement['name'],
                        'phone'        => $announcement['phone'],
                        'announcement' => $announcement
                    ]); ?>

                    <!-- EXCHANGE/PRICE -->
                    <?php if($row['type'] == Proposition::TYPE_EXCHANGE): ?>
                        <?php echo $this->render('common/exchange', [
                            'proposition' => $row,
                            'exchange'    => $outlayMyExchange[$row['announcement_exchange_id']]
                        ]); ?>
                    <?php else: ?>
                        <?php echo $this->render('common/price', [
                            'offeringPrice'     => $row['amount_display'],
                            'announcementPrice' => $outlayAnnouncements[$row['announcement_id']]['price']
                        ]); ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- PAGINATION -->
        <div class="toolbox clearfix">
            <?php echo $this->render('/partials/filters/paginator', [
                'dataProvider' => $outlayDataProvider
            ]); ?>

            <!-- PER PAGE -->
            <?php echo $this->render('common/per_page', [
                'action'    => 'propositions',
                'paramName' => 'outlay_pp',
                'type'      => ProfilePropositionService::TYPE_OUTLAY,
                'id'        => 'per_page_outlay'
            ]); ?>
        </div>

    <?php else: ?>
        <div class="empty-box profile-offers-empty">
            <p><?= Yii::t('profile', 'propositions_outlay_empty') ?></p>
        </div>
    <?php endif; ?>
</div>