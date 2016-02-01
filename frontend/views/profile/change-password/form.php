<?php

use kartik\password\PasswordInput;

?>

<table class="form-table">

    <!-- OLD PASSWORD -->
    <?php
        echo $form->field($model, 'password_old', [
            'options' => [
                'tag' => 'tr'
            ],
            'labelOptions' => [
                'class' => false,
                'label' => '<strong>' . $model->getAttributeLabel('password_old') . '</strong>'
            ],
            'inputOptions' => [
                'class' => 'textfield'
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'changepasword-password_old',
                'style' => 'display: none;'
            ],
            'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
        ])->passwordInput();
    ?>

    <!-- NEW PASSWORD -->
    <?php

        $strength   = Yii::t('profile', 'password_strength');
        $tooShort   = Yii::t('profile', 'password_too_short');
        $veryWeak   = Yii::t('profile', 'password_very_weak');
        $weak       = Yii::t('profile', 'password_weak');
        $good       = Yii::t('profile', 'password_good');
        $strong     = Yii::t('profile', 'password_strong');
        $veryStrong = Yii::t('profile', 'password_very_strong');

        $strengthTemplate = "<div class='password-strength'>
                                <ul id='indicator'>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                                <ul style='display:none;' id='verdict'>
                                    <li id='tooShort'>$tooShort</li>
                                    <li id='veryWeak'>$veryWeak</li>
                                    <li id='weak'>$weak</li>
                                    <li id='good'>$good</li>
                                    <li id='strong'>$strong</li>
                                    <li id='veryStrong'>$veryStrong</li>
                                </ul>
                                <span>$strength — <span id='strengthVerdict'>$tooShort</span></span>
                            </div>";

        echo $form->field($model, 'password', [
            'options' => [
                'tag' => 'tr'
            ],
            'labelOptions' => [
                'class' => false,
                'label' => '<strong>' . $model->getAttributeLabel('password') . '</strong>'
            ],
            'inputOptions' => [
                'class' => 'textfield'
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'changepasword-password',
                'style' => 'display: none;'
            ],
            'template' => "<td>{label}</td><td><div class='form-table-box pull-left'>{input}{error}</div>$strengthTemplate</td>",
        ])->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'language'   => 'ru',
                'showMeter'  => false,
                'toggleMask' => false,
                'showToggle' => false,
                'rules' => [
                    'midChar'       => 2,
                    'consecAlphaUC' => 2,
                    'consecAlphaLC' => 2,
                    'consecNumber'  => 2,
                    'seqAlpha'      => 3,
                    'seqNumber'     => 3,
                    'seqSymbol'     => 3,
                    'length'        => 4,
                    'number'        => 4,
                    'symbol'        => 6
                ],
                'inputClass' => 'textfield',
                'mainTemplate' => '<table class="kv-strength-container">
                                       <tr>
                                           <td>{input}</td>
                                       </tr>
                                   </table>'
            ]
        ]);
    ?>

    <!-- REPEAT PASSWORD -->
    <?php
        echo $form->field($model, 'password_repeat', [
            'options' => [
                'tag' => 'tr'
            ],
            'labelOptions' => [
                'class' => false,
                'label' => '<strong>' . $model->getAttributeLabel('password_repeat') . '</strong>'
            ],
            'inputOptions' => [
                'class' => 'textfield'
            ],
            'errorOptions' => [
                'tag'   => 'span',
                'class' => 'error-text',
                'for'   => 'changepasword-password_repeat',
                'style' => 'display: none;'
            ],
            'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
        ])->passwordInput();
    ?>

</table>
