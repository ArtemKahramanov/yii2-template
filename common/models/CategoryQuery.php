<?php

namespace common\models;

use common\behaviors\SeoBehavior;
use Yii;


class CategoryQuery extends \yii\db\ActiveQuery
{
    public function showMenu()
    {
        return $this->andWhere(['category.show_menu' => Category::SHOW_MENU]);
    }

    public function findSlug($slug)
    {
        return $this->andWhere(['seo.slug' => $slug])->innerJoinWith('seo');
    }
}
