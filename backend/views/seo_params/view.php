<?php
    $model->attachBehavior('SeoBehavior', new \common\behaviors\SeoBehavior());
    $model->getData();
?>
<div class="tab-pane fade" id="nav-profile">
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'slug')->hint('Автоматически генерируется по полю Title') ?>
    <?= $form->field($model, 'meta_keywords') ?>
    <?= $form->field($model, 'meta_description') ?>
</div>
