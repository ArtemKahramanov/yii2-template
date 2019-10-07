<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$this->registerJsFile('script/owl.carousel.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('css/owl.carousel.min.css');
$this->registerCssFile('css/owl.theme.default.min.css');
?>

<h2 class="title title--section">Каталог товаров</h2>

<h2 class="title title--section">Последние товары</h2>
<?php echo \frontend\widgets\BannerWidget::widget([]) ?>
