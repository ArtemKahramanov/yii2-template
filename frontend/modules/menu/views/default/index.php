<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Url;
use frontend\modules\menu\models\menu;


/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$model= Menu::find()->all();

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;

BootstrapAsset::register($this);

?>
<style>
    .child td:first-child{
        padding-left: 35px;
    }
</style>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function ($model, $key, $index, $grid){
            $class=$model->parent_id > 0 ? 'child' : '';
            return [
                'key'=>$key,
                'index'=>$index,
                'class'=>$class
            ];
        },
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'url:url',
            'sort',
            'parent_id',
            'type',
            'role',
            'method',
            [
                'class' => \yii\grid\ActionColumn::class,

                'template' => '{view} {update} {delete} {up} {down}',

                'buttons' => [
                    'up' => function ($url, $model) {

                        $items_sort = explode('.', $model->sort);

                        if(isset($items_sort[1]) && $items_sort[1] == 1){
                             return '';
                        }

                        if($model->sort > 1) {
                                $title = \Yii::t('yii', 'Up');
                                $url = Url::to(['default/change-order', 'direction' => 'up', 'id' => $model->id]);
                                $options = [
                                    'title' => $title,
                                    'aria-label' => $title,
                                    'data-pjax' => '0',
                                ];
                                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-arrow-up"]);
                                return Html::a($icon, $url, $options);
                        }
                    },

                    'down' => function ($url, $model) {
                        $items_sort = Menu::find()->where(['parent_id'=>$model->parent_id])->orderBy(['sort'=> SORT_DESC])->one();
                        $max_item = Menu::find()->max('sort');
                        if($max_item != $model->sort && $items_sort->sort != $model->sort){
                            $title = \Yii::t('yii', 'Down');
                            $url = Url::to(['default/change-order', 'direction' => 'down', 'id' => $model->id]);
                            $options = [
                                'title' => $title,
                                'aria-label' => $title,
                                'data-pjax' => '0',
                            ];
                            $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-arrow-down"]);
                            return Html::a($icon, $url, $options);
                        }
                    },
                ],
            ],
        ],
    ]); ?>
</div>
