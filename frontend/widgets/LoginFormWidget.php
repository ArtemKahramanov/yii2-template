<?php

namespace  frontend\widgets;

use dektrium\user\Finder;
use dektrium\user\models\LoginForm;
use dektrium\user\Module;
use yii\base\Widget;

class LoginFormWidget extends Widget {

    public function run() {
        if (\Yii::$app->user->isGuest) {
            $finder = new Finder();
            $model = new LoginForm($finder);
            $module = \Yii::$app->getModule('user');
            return $this->render('login_widget', [
                'model' => $model,
                'module' => $module
            ]);
        }
    }

}
