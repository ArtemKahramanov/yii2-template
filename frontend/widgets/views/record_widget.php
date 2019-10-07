<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>

<div class="modal fade" id="recordModalWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?= $course->name ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                    'id' => 'record-form',
                ]); ?>
            <div class="modal-body">
                <?= $form->field($entity, 'course_id')->hiddenInput(['value'=> $course->id])->label('') ?>
                <?= $form->field($entity, 'name') ?>
                <?= $form->field($entity, 'phone') ?>
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
    
$('#record-form').on('beforeSubmit', function (event) {
    var form_data = $('#record-form').serialize();
    $.ajax({
        url: '/record/send',
        cache: false,
        method: 'post',
        data: form_data,
        success: function (res) {
            var response = JSON.parse(res);
            if (response.status === true){
                $('#recordModalWindow').modal('toggle');
                $('#success-record').modal('show');
            } else {
                alert(response.error ? response.error : 'Произошла ошибка');
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
