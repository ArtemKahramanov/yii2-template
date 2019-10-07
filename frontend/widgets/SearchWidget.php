<?php

namespace  frontend\widgets;

use  frontend\forms\SearchForm;
use yii\base\Widget;

class SearchWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $search = new SearchForm();

        return $this->render('search_widget', [
            'search' => $search
        ]);
    }
}
