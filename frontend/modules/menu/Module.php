<?php

namespace frontend\modules\menu;


class Module extends \yii\base\Module
{
    /** @var string Назначение класса для элементов с выпадающим меню */
    public $dropmenu_class = 'menu__dropdown';

    /** @var bool Если True, подпункты Dropmenu будут удалены, при False останутся, Parent будет установлен 0 */
    public $deletion_strategy = false;

    public function init()
    {
        parent::init();
    }
}
