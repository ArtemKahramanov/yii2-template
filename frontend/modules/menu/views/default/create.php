<?php

use yii\helpers\Html;
use yii\bootstrap\BootstrapAsset;


/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Create Menu';
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

BootstrapAsset::register($this);
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    --><?php //var_dump($model->menu); die; ?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
