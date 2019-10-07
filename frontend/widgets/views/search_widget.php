<?php

use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'action' => '/search',
]); ?>

<i class="fas fa-search"></i>
<?= $form->field($search, 'name')
    ->textInput(['maxlength' => 255, 'class' => 'input input--search', 'placeholder' => 'Поиск по сайту'])
    ->label(false) ?>

<?php ActiveForm::end(); ?>
