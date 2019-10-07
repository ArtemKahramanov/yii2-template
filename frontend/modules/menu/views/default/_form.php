<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\bootstrap\BaseHtml;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map($model::$menuTypes, 'type', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($model::find()->where(['type'=>'Dropmenu'])->all(), 'id', 'name'),
        ['prompt' => [
            'text' => 'Выбрать родителя',
            'options' => [
                'value' => 0,
            ],
        ]]
    ) ?>

    <?= $form->field($model, 'role')->dropDownList(ArrayHelper::map($model::$rols, 'identify', 'label')) ?>

    <?= $form->field($model, 'method')->dropDownList(ArrayHelper::map($model::$method, 'id', 'name')) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => '255']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
