<?php

namespace  frontend\widgets;

use  frontend\models\CourseBanner;
use  frontend\models\Record;
use yii\base\Widget;

class RecordWidget extends Widget
{
    public $id;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $entity = new Record();
        $course = CourseBanner::findOne($this->id);

        return $this->render('record_widget', [
            'entity' => $entity,
            'course' => $course
        ]);
    }
}
