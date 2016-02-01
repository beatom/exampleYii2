<?php

use frontend\models\Profile\Proposition;
use frontend\widgets\NewAuto\Widget as NewAutoWidget;

?>

<article>
    <section class="box block">

        <!-- BREADCRUMBS -->
        <?php echo $this->render('partials/breadcrumbs', [
            'crumb' => Yii::t('profile', 'breadcrumbs_propositions')
        ]); ?>

        <section class="profile-page tabs">

            <!-- HEADING -->
            <div class="heading">
                <h1 class="profile-header-offers">
                    <?= Yii::t('profile', 'propositions') ?>
                </h1>

                <!-- TABS -->
                <div class="tabs-nav tabs-nav-buttons">
                    <?php
                        $incomeClass = '';
                        $outlayClass = '';
                        $filterIncomeStyle = 'display:none;';
                        $filterOutlayStyle = 'display:none;';
                        switch($type) {
                            case Proposition::TYPE_INCOME:
                                $incomeClass       = 'active';
                                $filterIncomeStyle = 'display:block;';
                                break;
                            case Proposition::TYPE_OUTLAY:
                                $outlayClass       = 'active';
                                $filterOutlayStyle = 'display:block;';
                                break;
                            default:
                                $incomeClass       = 'active';
                                $filterIncomeStyle = 'display:block;';
                                break;
                        }
                    ?>
                    <div class="tabs-nav-link <?= $incomeClass ?>" id="income_tab">
                        <?= Yii::t('profile', 'propositions_income') ?>
                    </div>
                    <div class="tabs-nav-link <?= $outlayClass ?>" id="outlay_tab">
                        <?= Yii::t('profile', 'propositions_outlay') ?>
                    </div>
                </div>

                <!-- FILTER -->
                <div class="view-filter" style="width:154px; <?= $filterIncomeStyle ?>" id="income_filter">
                    <?php echo $this->render('propositions/common/filter', [
                        'type' => Proposition::TYPE_INCOME,
                        'id'   => 'interest_income'
                    ]); ?>
                </div>

                <div class="view-filter" style="width:154px; <?= $filterOutlayStyle ?>" id="outlay_filter">
                    <?php echo $this->render('propositions/common/filter', [
                        'type' => Proposition::TYPE_OUTLAY,
                        'id'   => 'interest_outlay'
                    ]); ?>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="tabs-content">

                <!-- INCOME -->
                <?php echo $this->render('propositions/income', [
                    'incomeMyAnnouncements' => $incomeMyAnnouncements,
                    'incomeExchange'        => $incomeExchange,
                    'incomeDataProvider'    => $incomeDataProvider,
                    'incomeClass'           => $incomeClass
                ]); ?>

                <!-- OUTLAY -->
                <?php echo $this->render('propositions/outlay', [
                    'outlayAnnouncements'   => $outlayAnnouncements,
                    'outlayMyExchange'      => $outlayMyExchange,
                    'outlayDataProvider'    => $outlayDataProvider,
                    'outlayClass'           => $outlayClass
                ]); ?>
            </div>
        </section>

    </section>
</article>

<!-- NEW AUTO -->
<?= NewAutoWidget::widget(['limit' => 6]) ?>
