<?php

namespace  frontend\widgets;

use yii\base\Widget;

class BannerWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
//        $banners = \Yii::$app->db->cache(function () {
//            return CourseBanner::find()->limit(10)->all();
//        }, 86400);

        return $this->render('banner_widget', [
//            'banners' => $banners,
        ]);
    }
}
