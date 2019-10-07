<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
     id="contact-form-success"
     aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title title--modal">Спасибо за обращение! </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>В ближайшее время, наш менеджер свяжется с Вами</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Обратная связь</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'contact-form'
            ]); ?>
            <div class="modal-body">
                <?= $form->field($entity, 'name')->textInput() ?>
                <?= $form->field($entity, 'mail')->input('email') ?>
                <?= $form->field($entity, 'body')->textarea(['rows' => 5]) ?>
                <?= $form->field($entity, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(),
                    ['siteKey' => '6Lel0qcUAAAAAOB1-YoAaliDinnhW7030r0Zye55']
                ) ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn--primary">Отправить</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    
$('#contact-form').on('beforeSubmit', function (event) {
    var form_data = $('#contact-form').serialize();
    $.ajax({
        url: '/contact/contact/send',
        cache: false,
        method: 'post',
        data: form_data,
        success: function (res) {
            var response = JSON.parse(res);
            if (response.status === true){
                $('#contactModalWindow').modal('toggle');
                $('#contact-form-success').modal('toggle');
            } else {
                alert('Произошла ошибка');
            }
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
