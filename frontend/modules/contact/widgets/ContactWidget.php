<?php

namespace app\modules\contact\widgets;

use app\modules\contact\entities\Contact;
use yii\base\Widget;

class ContactWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $entity = new Contact();

        return $this->render('contact', [
            'entity' => $entity,
        ]);
    }
}
