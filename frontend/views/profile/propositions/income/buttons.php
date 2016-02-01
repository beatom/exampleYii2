<?php

use common\models\Proposition;
use yii\helpers\Url;

?>

<!-- АКТИВНО -->
<?php if($proposition['exchange_seller_interest'] == Proposition::EXCHANGE_SELLER_INTEREST_NONE): ?>
    <ul class="offers-list-buttons">
        <li>
            <?php echo $this->render('/partials/propositions/hidden_form', [
                'id'                       => $proposition['id'],
                'formClass'                => 'formInteresting',
                'exchange_seller_interest' => Proposition::EXCHANGE_SELLER_INTEREST_YES
            ]); ?>
            <a href="" class="offers-list-yes interesting"></a>
        </li>
        <li>
            <?php echo $this->render('/partials/propositions/hidden_form', [
                'id'                       => $proposition['id'],
                'formClass'                => 'formUnsuitable',
                'exchange_seller_interest' => Proposition::EXCHANGE_SELLER_INTEREST_NO
            ]); ?>
            <a href="" class="offers-list-no unsuitable"></a>
        </li>
    </ul>

<!-- ПРИНЯТО/ОТКЛОНЕНО -->
<?php elseif($proposition['exchange_seller_interest'] == Proposition::EXCHANGE_SELLER_INTEREST_YES ||
             $proposition['exchange_seller_interest'] == Proposition::EXCHANGE_SELLER_INTEREST_NO): ?>
    <ul class="offers-list-buttons">
        <li>
            <?php $href = Url::to(['catalog/view', 'id' => $proposition['announcement_id']]); ?>
            <a href="<?= $href ?>" class="offers-list-go"></a>
        </li>
        <li>
            <?php echo $this->render('/partials/propositions/hidden_form', [
                'id'                       => $proposition['id'],
                'formClass'                => 'formCancel',
                'exchange_seller_interest' => Proposition::EXCHANGE_SELLER_INTEREST_NONE
            ]); ?>
            <a href="" class="offers-list-no cancel"></a>
        </li>
    </ul>
<?php endif; ?>
