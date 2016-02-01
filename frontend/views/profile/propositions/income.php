<?php

use common\models\Proposition;
use frontend\models\Profile\Proposition as ProfilePropositionService;

?>

<?php

    $style = 'display: none;';
    if($incomeClass) {
        $style = 'display: block;';
    }
?>

<div class="tab" style="<?= $style ?>">

    <?php if($incomeDataProvider->getTotalCount()): ?>
        <ul class="offers-list-header clearfix">
            <li><?= Yii::t('profile', 'propositions_income_heading_auto') ?></li>
            <li><?= Yii::t('profile', 'propositions_income_heading_proposed') ?></li>
            <li><?= Yii::t('profile', 'propositions_income_heading_your_price') ?></li>
        </ul>

        <ul class="offers-list">
            <?php foreach($incomeDataProvider->getModels() as $row): ?>
                <li>

                    <!-- MAIN -->
                    <?php echo $this->render('common/main', [
                        'proposition'  => $row,
                        'phone'        => $row['phone'],
                        'name'         => $row['name'],
                        'announcement' => $incomeMyAnnouncements[$row['announcement_id']]
                    ]); ?>

                    <!-- EXCHANGE/PRICE -->
                    <?php if($row['type'] == Proposition::TYPE_EXCHANGE): ?>
                        <?php echo $this->render('common/exchange', [
                            'proposition' => $row,
                            'exchange' => $incomeExchange[$row['announcement_exchange_id']]
                        ]); ?>
                    <?php else: ?>
                        <?php echo $this->render('common/price', [
                            'offeringPrice'     => $row['amount_display'],
                            'announcementPrice' => $incomeMyAnnouncements[$row['announcement_id']]['price']
                        ]); ?>
                    <?php endif; ?>

                    <!-- BUTTONS -->
                    <?php echo $this->render('income/buttons', [
                        'proposition' => $row
                    ]); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- PAGINATION -->
        <div class="toolbox clearfix">
            <?php echo $this->render('/partials/filters/paginator', [
                'dataProvider' => $incomeDataProvider
            ]); ?>

            <!-- PER PAGE -->
            <?php echo $this->render('common/per_page', [
                'action'    => 'propositions',
                'paramName' => 'income_pp',
                'type'      => ProfilePropositionService::TYPE_INCOME,
                'id'        => 'per_page_income'
            ]); ?>
        </div>

    <?php else: ?>
        <div class="empty-box profile-offers-empty">
            <p><?= Yii::t('profile', 'propositions_income_empty') ?></p>
        </div>
    <?php endif; ?>
</div>