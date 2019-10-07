<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\modules\menu\models\Menu as mainMenu;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="navigate">
    <div class="container navigate__content">
        <a href="/"> <img src="img/logo.png" alt="" class="logo"></a>
        <button class="btn btn--menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
        <?php
        $items = mainMenu::getMenu();

        echo yii\widgets\Menu::widget([
            'items' => $items,
            'options' => [
                'class' => 'menu'
            ],
            'submenuTemplate' => "<ul class='drop-menu'>\n{items}\n</ul>\n",
        ]); ?>
    </div>
</nav>

<section class="contact">
    <p><i class="fas fa-phone"></i> <a href="#" class="phone">+7 (900) 900 32-32</a></p>
    <button class="btn btn--primary">Заказать звонок</button>
</section>

<div class="wrap">
    
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
