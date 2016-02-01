<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'editForm']); ?>

    <div class="half block">
        <h5><?= Yii::t('profile', 'edit_private_info') ?></h5>

        <table class="form-table">

            <!-- FIRSTNAME -->
            <?php
                echo $form->field($model, 'firstname', [
                    'options' => [
                        'tag' => 'tr'
                    ],
                    'labelOptions' => [
                        'class' => false,
                        'label' => '<strong>' . $model->getAttributeLabel('firstname') . '</strong>'
                    ],
                    'inputOptions' => [
                        'class' => 'textfield'
                    ],
                    'errorOptions' => [
                        'tag'   => 'span',
                        'class' => 'error-text',
                        'for'   => 'user-firstname',
                        'style' => 'display: none;'
                    ],
                    'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
                ])->textInput();
            ?>

            <!-- LASTNAME -->
            <?php
                echo $form->field($model, 'lastname', [
                    'options' => [
                        'tag' => 'tr'
                    ],
                    'labelOptions' => [
                        'class' => false,
                        'label' => '<strong>' . $model->getAttributeLabel('lastname') . '</strong>'
                    ],
                    'inputOptions' => [
                        'class' => 'textfield'
                    ],
                    'errorOptions' => [
                        'tag'   => 'span',
                        'class' => 'error-text',
                        'for'   => 'user-lastname',
                        'style' => 'display: none;'
                    ],
                    'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
                ])->textInput();
            ?>

            <!-- EMAIL -->
            <?php
                echo $form->field($model, 'email', [
                    'options' => [
                        'tag' => 'tr'
                    ],
                    'labelOptions' => [
                        'class' => false,
                        'label' => '<strong>' . $model->getAttributeLabel('email') . '</strong>'
                    ],
                    'inputOptions' => [
                        'class' => 'textfield'
                    ],
                    'errorOptions' => [
                        'tag'   => 'span',
                        'class' => 'error-text',
                        'for'   => 'user-email',
                        'style' => 'display: none;'
                    ],
                    'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
                ])->textInput();
            ?>

            <!-- MOBILE PHONE -->
            <tr>
                <td>
                    <label><strong><?= Yii::t('profile', 'edit_mobile_phone') ?></strong></label>
                </td>
                <td>
                    <div class="form-table-box clearfix">
                        <div class="pull-left"><?= $model->phone ?></div>

                        <div class="pull-right">
                            <a href="<?= Url::to(['profile/remove-phone']) ?>" class="button button-lite button-success button-change-phone">
                                <?= Yii::t('profile', 'edit_remove_phone') ?>
                            </a>
                        </div>

                    </div>
                </td>
            </tr>

        </table>
    </div>

    <!-- PHOTO -->
    <?php echo $this->render('form/photo', [
        'images'    => $images,
        'mainImage' => $mainImage
    ]); ?>

    <div class="clear"></div>

    <!-- SOCIALS -->
    <?php
        \frontend\widgets\CustomEauth\Widget::$_TPL = 'profileBinds';
        \frontend\widgets\CustomEauth\Widget::$_USER = $user;
        echo \frontend\widgets\CustomEauth\Widget::widget(array('action' => 'profile/edit'));
    ?>

    <div class="clear"></div>

    <div class="half block">
        <h5><?= Yii::t('profile', 'edit_contact_info') ?></h5>

        <table class="form-table">
            <tr>
                <td>
                    <label><strong><?= Yii::t('profile', 'edit_mobile_phone_caption') ?></strong></label>
                </td>
                <td>
                    <div class="form-table-box">

                        <!-- PHONE 1 -->
                        <?php
                            $checkbox = $form->field($model, 'extra_phone1_disable', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'check-box'
                                ],
                                'labelOptions' => [
                                    'class' => 'checkbox-label',
                                ],
                                'template' => "<span class='niceCheck'>{input}</span>{label}",
                            ])->checkbox([], false);

                            echo $form->field($model, 'extra_phone1', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'clearfix block-lite rel'
                                ],
                                'inputOptions' => [
                                    'class' => 'textfield textfield-middle pull-left'
                                ],
                                'errorOptions' => [
                                    'tag'   => 'span',
                                    'class' => 'error-text',
                                    'for'   => 'user-extra_phone1',
                                    'style' => 'display: none;'
                                ],
                                'template' => "<div class='clearfix'>{input}</div>{error}$checkbox",
                            ])->textInput();
                        ?>

                        <!-- PHONE 2 -->
                        <?php
                            $checkbox = $form->field($model, 'extra_phone2_disable', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'check-box'
                                ],
                                'labelOptions' => [
                                    'class' => 'checkbox-label',
                                ],
                                'template' => "<span class='niceCheck'>{input}</span>{label}",
                            ])->checkbox([], false);

                            echo $form->field($model, 'extra_phone2', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'clearfix block-lite rel'
                                ],
                                'inputOptions' => [
                                    'class' => 'textfield textfield-middle pull-left'
                                ],
                                'errorOptions' => [
                                    'tag'   => 'span',
                                    'class' => 'error-text',
                                    'for'   => 'user-extra_phone2',
                                    'style' => 'display: none;'
                                ],
                                'template' => "<div class='clearfix'>{input}</div>{error}$checkbox",
                            ])->textInput();
                        ?>

                        <!-- PHONE 3 -->
                        <?php
                            $checkbox = $form->field($model, 'extra_phone3_disable', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'check-box'
                                ],
                                'labelOptions' => [
                                    'class' => 'checkbox-label',
                                ],
                                'template' => "<span class='niceCheck'>{input}</span>{label}",
                            ])->checkbox([], false);

                            echo $form->field($model, 'extra_phone3', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'clearfix block-lite rel'
                                ],
                                'inputOptions' => [
                                    'class' => 'textfield textfield-middle pull-left'
                                ],
                                'errorOptions' => [
                                    'tag'   => 'span',
                                    'class' => 'error-text',
                                    'for'   => 'user-extra_phone3',
                                    'style' => 'display: none;'
                                ],
                                'template' => "<div class='clearfix'>{input}</div>{error}$checkbox",
                            ])->textInput();
                        ?>

                        <!-- PHONE 4 -->
                        <?php
                            $checkbox = $form->field($model, 'extra_phone4_disable', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'check-box'
                                ],
                                'labelOptions' => [
                                    'class' => 'checkbox-label',
                                ],
                                'template' => "<span class='niceCheck'>{input}</span>{label}",
                            ])->checkbox([], false);

                            echo $form->field($model, 'extra_phone4', [
                                'options' => [
                                    'tag' => 'div',
                                    'class' => 'clearfix block-lite rel'
                                ],
                                'inputOptions' => [
                                    'class' => 'textfield textfield-middle pull-left'
                                ],
                                'errorOptions' => [
                                    'tag'   => 'span',
                                    'class' => 'error-text',
                                    'for'   => 'user-extra_phone4',
                                    'style' => 'display: none;'
                                ],
                                'template' => "<div class='clearfix'>{input}</div>{error}$checkbox",
                            ])->textInput();
                        ?>
                    </div>
                </td>
            </tr>

            <!-- SKYPE -->
            <?php
                echo $form->field($model, 'skype', [
                    'options' => [
                        'tag' => 'tr'
                    ],
                    'labelOptions' => [
                        'class' => false,
                        'label' => '<strong>' . $model->getAttributeLabel('skype') . '</strong>'
                    ],
                    'inputOptions' => [
                        'class' => 'textfield'
                    ],
                    'errorOptions' => [
                        'tag'   => 'span',
                        'class' => 'error-text',
                        'for'   => 'user-skype',
                        'style' => 'display: none;'
                    ],
                    'template' => "<td>{label}</td><td><div class='form-table-box'>{input}{error}</div></td>",
                ])->textInput();
            ?>

        </table>

        <!-- SHOW EMAIL CHECKBOX -->
        <?php
            echo $form->field($model, 'show_email', [
                'options' => [
                    'tag' => 'div',
                    'class' => 'check-box clearfix'
                ],
                'labelOptions' => [
                    'class' => 'checkbox-label',
                ],
                'template' => "<span class='niceCheck'>{input}</span>{label}{error}",
            ])->checkbox([], false);
        ?>
    </div>

    <div class="clear"></div>

    <!-- SUBMIT -->
    <div class="clearfix">
        <a href="" id="submit" class="button button-important pull-left"><?= Yii::t('profile', 'edit_submit') ?></a>
    </div>

<?php ActiveForm::end(); ?>
