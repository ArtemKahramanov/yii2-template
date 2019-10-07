<?php

use kartik\tree\TreeView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-index">

    <?= TreeView::widget([
        'query' => $category->addOrderBy('root, lft'),

        'headingOptions' => ['label' => 'Категории'],
        'fontAwesome' => false,     // optional
        'isAdmin' => true,         // optional (toggle to enable admin mode)
        'displayValue' => 1,        // initial display value
        'softDelete' => false,       // defaults to true
        'cacheSettings' => [
            'enableCache' => false   // defaults to true
        ],
        'nodeViewButtonLabels' => [
            'submit' => '<i class="fas fa-save"></i>',
            'reset' => '<i class="fas fa-redo-alt"></i>'
        ]
    ]); ?>
</div>
