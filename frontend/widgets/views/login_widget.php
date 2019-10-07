<?php

namespace  frontend\views\widgets;

use Yii;
use yii\widgets\ActiveForm;

/*  @var $module */
/*  @var $model */
?>


<div class="modal fade" id="loginModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Авторизация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
//                'validateOnBlur' => false,
//                'validateOnType' => false,
//                'validateOnChange' => false,
            ]) ?>

            <?php if ($module->debug): ?>
                <?= $form->field($model, 'login', [
                    'inputOptions' => [
                        'autofocus' => 'autofocus',
                        'class' => 'input',
                        'tabindex' => '1']])->dropDownList(\dektrium\user\models\LoginForm::loginList());
                ?>

            <?php else: ?>

                <?= $form->field($model, 'login',
                    [
                        'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'input input--form', 'tabindex' => '1'],
                        // 'options' => ['class' => 'inpug-group']
                    ]
                );
                ?>

            <?php endif ?>

            <?php if ($module->debug): ?>
                <div class="alert alert-warning">
                    <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                </div>
            <?php else: ?>
                <?= $form->field(
                    $model,
                    'password',
                    ['inputOptions' => ['class' => 'input input--form', 'tabindex' => '2']])
                    ->passwordInput()
                    ->label(
                        Yii::t('user', 'Password')
                        . ($module->enablePasswordRecovery ?
                            ' (' . \yii\helpers\Html::a(
                                Yii::t('user', 'Forgot password?'),
                                ['/user/recovery/request'],
                                ['class' => 'link'],
                                ['tabindex' => '5']
                            )
                            . ')' : '')
                    ) ?>
            <?php endif ?>

            <!-- <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'checkbox']])->checkbox(['tabindex' => '3']) ?> -->
            <?= $form->field($model, 'rememberMe', [
                'options' => ['class' => 'checkbox'],
                'template' => "{input} {label} {error}",
            ])->checkbox([
                'id' => 'login-form-rememberme',
                'name' => 'login-form[rememberMe]'
            ], false)->label('Запомнить меня', [
                'class' => 'checkbox-label',
            ]); ?>


            <?= \yii\helpers\Html::submitButton(
                Yii::t('user', 'Sign in'),
                ['class' => 'btn btn--w100', 'tabindex' => '4']
            ) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


    <?php
$js = <<<JS
    
$('#login-form').on('beforeSubmit', function (event) {
    var form_data = $('#login-form').serialize();
    $.ajax({
        url: '/site/login',
        cache: false,
        method: 'post',
        data: form_data,
        success: function () {
            $('#loginModalWindow').modal('toggle');
            // $('#success-record').modal('show');
            // location.reload();
        },
        error: function () {
            alert('Произошла ошибка');
        },
    });
}).on('submit', function (event) {
    event.stopPropagation();
    event.preventDefault();
    });

JS;
$this->registerJs($js);
?>
